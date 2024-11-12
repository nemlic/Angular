import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { AuthService } from '../services/auth.service';
import { Router } from '@angular/router';
import { MustMatch } from '../confirm.validator';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css']
})
export class RegisterComponent implements OnInit {
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
      name: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required, Validators.minLength(4)]],
      password_confirmation: ['', Validators.required],
      role: ['', Validators.required]
    }, {
      validator: this.MustMatch('password', 'password_confirmation')
    });
  }

  // Custom validator to check if passwords match
  MustMatch(controlName: string, matchingControlName: string) {
    return (formGroup: FormGroup) => {
      const control = formGroup.controls[controlName];
      const matchingControl = formGroup.controls[matchingControlName];

      if (matchingControl.errors && !matchingControl.errors['mustMatch']) {
        return;
      }

      if (control.value !== matchingControl.value) {
        matchingControl.setErrors({ mustMatch: true });
      } else {
        matchingControl.setErrors(null);
      }
    };
  }

  get f() { return this.form.controls; }

  onSubmit(event: Event) {
    event.preventDefault(); // Prevent default form submission
    this.submitted = true;

    // Prevent submission if form is invalid
    if (this.form.invalid) {
      return;
    }

    // Call the authService to register
    this.authService.register(this.form.value).subscribe(
      data => {
        console.log('User registered successfully', data);
        this.successMessage = 'User registered successfully!';
        this.errorMessage = null;
        this.router.navigate(['/login']);
      },
      error => {
        console.log('Registration failed', error);
        this.successMessage = null;
        this.errorMessage = error.error.message || 'Registration failed. Please try again.';
      }
    );
  }
}
