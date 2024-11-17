import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { jwtDecode } from 'jwt-decode';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrl: './home.component.css'
})
export class HomeComponent {
  token:any;
  userData:any
  email:any
  constructor(private router:Router){}
  
  ngOnInit():void{
    this.token=localStorage.getItem('token');
    this.userData=jwtDecode(this.token);
    this.email=this.userData.email
    console.log(this.token)
    console.log(this.userData.email)
 
  }
 
  logout(){
    localStorage.removeItem('token');
    this.router.navigate([''])
  }
}

