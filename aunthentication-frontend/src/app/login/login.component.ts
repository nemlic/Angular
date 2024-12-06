import { Component } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { ToastrService } from 'ngx-toastr';
import { DataService } from '../service/data.service';
import { MustMatch } from '../confirm.validator';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrl: './login.component.css'
})
export class LoginComponent {
  form!: FormGroup;
  submitted = false;
  data: any;
  token:any;

  constructor(
    private formBuilder: FormBuilder,
    private dataservice: DataService,
    private toastr: ToastrService,
    private router:Router
  ) {}

  loginForm(){
    this.form=this.formBuilder.group({
      email:['',[Validators.required,Validators.email]],
    password:['',[Validators.required,Validators.minLength(6)]]
    })
  }
   
   ngOnInit(): void{
      this.loginForm();
   
    }
   

  get f() {
    return this.form.controls;
  }

  onSubmit() {
    this.submitted = true;
    if (this.form.invalid) {
      return;
    }
    this.dataservice.login(this.form.value).subscribe(
      res=>{
        this.data=res;
        if(this.data.status===1){
   
          this.token=this.data.data.token;
          localStorage.setItem('token', this.token);
          this.router.navigate(['/']);
          this.toastr.success(JSON.stringify(this.data.message),JSON.stringify(this.data.code),{
            timeOut:2000,
            progressBar:true
          })
         
           }
         
          else if(this.data.status===0){
            this.toastr.error(JSON.stringify(this.data.message),JSON.stringify(this.data.code),{
              timeOut:2000,
              progressBar:true
            })
           }
         
      }
    );
  }
}
