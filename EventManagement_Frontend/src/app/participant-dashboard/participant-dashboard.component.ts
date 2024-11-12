import { Component, OnInit } from '@angular/core';
import { ParticipantService } from '../services/participant.service';

@Component({
  selector: 'app-participant-dashboard',
  templateUrl: './participant-dashboard.component.html',
  styleUrls: ['./participant-dashboard.component.css']
})
export class ParticipantDashboardComponent implements OnInit {
  events: any[] = [];
  successMessage: string | null = null;
  errorMessage: string | null = null;

  constructor(private participantService: ParticipantService) {}

  ngOnInit(): void {
    this.loadEvents();
  }

  loadEvents(): void {
    this.participantService.getEvents().subscribe(
      data => {
        this.events = data.data; // Adjust according to your API response structure
      },
      error => {
        this.errorMessage = 'Failed to load events.';
      }
    );
  }

  register(eventId: number): void {
    this.participantService.registerForEvent(eventId).subscribe(
      data => {
        this.successMessage = data.message || 'Registered successfully!';
        this.errorMessage = null;
      },
      error => {
        this.successMessage = null;
        this.errorMessage = error.error.message || 'Failed to register.';
      }
    );
  }
}
