import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { AuthService } from '../services/auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  form!: FormGroup;
  submitted = false;
  successMessage: string | null = null;
  errorMessage: string | null = null;

  constructor(
    private formBuilder: FormBuilder, 
    private authService: AuthService, 
    private router: Router
  ) {}

  ngOnInit(): void {
    this.form = this.formBuilder.group({
      email: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required, Validators.minLength(4)]]
    });
  }

  get f() { return this.form.controls; }

  onSubmit(event: Event) {
    event.preventDefault(); // Prevent default form submission
    this.submitted = true;

    if (this.form.invalid) {
      return;
    }

    this.authService.login(this.form.value).subscribe(
      data => {
        console.log('Login successful', data);
        this.successMessage = 'Login successful!';
        this.errorMessage = null;
        
        // Navigate to the correct dashboard based on user role
        const userRole = data.data.user.role;
        if (userRole === 'admin') {
          this.router.navigate(['/admin-dashboard']);
        } else if (userRole === 'organizer') {
          this.router.navigate(['/organizer-dashboard']);
        } else if (userRole === 'participant') {
          this.router.navigate(['/participant-dashboard']);
        }
      },
      error => {
        console.log('Login failed', error);
        this.successMessage = null;
        this.errorMessage = error.error.message || 'Login failed. Please try again.';
      }
    );
  }
}
