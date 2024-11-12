import { Component } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { MustMatch } from '../confirm.validator';


@Component({
  selector: 'app-registration',
  templateUrl: './registration.component.html',
  styleUrl: './registration.component.css'
})
export class RegistrationComponent {

  form!: FormGroup;
  submitted=false;

  constructor (private formBuilder: FormBuilder){}
  createForm(){
    this.form=this.formBuilder.group({
     
     name:[null,Validators.required],
     email:['',[Validators.required,Validators.email]],
     password:['',[Validators.required,Validators.minLength(6)]],
     confirmpassword:['',[Validators.required]]
     
    },

    {validator: MustMatch('password','confirmpassword')}
  )
    }
    ngOnInit(): void{
      this.createForm();
   }

    get f(){
      return this.form.controls;
    }

    onSubmit(){
      this.submitted=true;
       if(this.form.invalid){
        return;
         }
   
    }
}
