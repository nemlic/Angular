import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { OrganizerService } from '../services/organizer.service';

@Component({
  selector: 'app-organizer-dashboard',
  templateUrl: './organizer-dashboard.component.html',
  styleUrls: ['./organizer-dashboard.component.css']
})
export class OrganizerDashboardComponent implements OnInit {
  events: any[] = [];
  eventForm: FormGroup;
  submitted = false;
  successMessage: string | null = null;
  errorMessage: string | null = null;
  isModalOpen = false;
  isEditMode = false;
  currentEventId: number | null = null;
  loading = false; // New loading state

  constructor(
    private formBuilder: FormBuilder,
    private organizerService: OrganizerService
  ) {
    this.eventForm = this.formBuilder.group({
      title: ['', Validators.required],
      description: ['', Validators.required],
      date: ['', Validators.required],
      location: ['', Validators.required],
      category: ['', Validators.required],
      image: [null]
    });
  }

  ngOnInit(): void {
    this.loadEvents();
  }

  get f() { return this.eventForm.controls; }

  loadEvents(): void {
    this.organizerService.getEvents().subscribe(
      data => {
        console.log('Loaded events:', data); // Add log here
        this.events = data.events.data; // Adjust according to your API response structure
      },
      error => {
        this.errorMessage = error?.error?.message || 'Failed to load events.';
      }
    );
  }

  openCreateEventModal(): void {
    console.log('Opening create event modal'); // Add log here
    this.isEditMode = false;
    this.isModalOpen = true;
    this.eventForm.reset();
    this.submitted = false;
  }

  openEditEventModal(event: any): void {
    console.log('Opening edit event modal for event:', event); // Add log here
    this.isEditMode = true;
    this.isModalOpen = true;
    this.currentEventId = event.id;
    this.eventForm.patchValue(event);
  }

  closeModal(): void {
    console.log('Closing modal'); // Add log here
    this.isModalOpen = false;
    this.eventForm.reset(); // Reset the form after closing
    this.submitted = false; // Reset submission status
  }

  onFileChange(event: any): void {
    if (event.target.files.length > 0) {
      const file = event.target.files[0];
      this.eventForm.patchValue({
        image: file
      });
      console.log('Selected file:', file); // Add log here
    }
  }

  onSubmit(): void {
    this.submitted = true;
    console.log('Form submitted:', this.eventForm.value); // Add log here

    if (this.eventForm.invalid) {
      console.log('Form is invalid'); // Add log here
      return;
    }

    this.loading = true; // Start loading state
    const formData = new FormData();
    Object.keys(this.eventForm.controls).forEach(key => { 
      const value = this.eventForm.get(key)?.value; 
      if (value instanceof File) { 
        formData.append(key, value, value.name); 
      } else { 
        formData.append(key, value); 
      }
    });

    if (this.isEditMode && this.currentEventId !== null) {
      this.organizerService.updateEvent(this.currentEventId, formData).subscribe(
        data => {
          console.log('Event updated successfully:', data); // Add log here
          this.successMessage = 'Event updated successfully!';
          this.errorMessage = null;
          this.loadEvents();
          this.closeModal();
          this.loading = false; // Stop loading state
        },
        error => {
          console.error('Error updating event:', error); // Add log here
          this.successMessage = null;
          this.errorMessage = error?.error?.message || 'Failed to update event.';
          this.loading = false; // Stop loading state on error
        }
      );
    } else {
      this.organizerService.createEvent(formData).subscribe(
        data => {
          console.log('Event created successfully:', data); // Add log here
          this.successMessage = 'Event created successfully!';
          this.errorMessage = null;
          this.loadEvents();
          this.closeModal();
          this.loading = false; // Stop loading state
        },
        error => {
          console.error('Error creating event:', error); // Add log here
          this.successMessage = null;
          this.errorMessage = error?.error?.message || 'Failed to create event.';
          this.loading = false; // Stop loading state on error
        }
      );
    }
  }

  deleteEvent(eventId: number): void {
    console.log('Deleting event with ID:', eventId); // Add log here
    this.organizerService.deleteEvent(eventId).subscribe(
      data => {
        console.log('Event deleted successfully:', data); // Add log here
        this.successMessage = 'Event deleted successfully!';
        this.errorMessage = null;
        this.loadEvents(); // Refresh the event list after deletion
      },
      error => {
        console.error('Error deleting event:', error); // Add log here
        this.successMessage = null;
        this.errorMessage = error?.error?.message || 'Failed to delete event.';
      }
    );
  }
}
