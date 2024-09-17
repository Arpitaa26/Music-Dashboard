import { Component } from '@angular/core';
import {
  AbstractControl,
  FormControl,
  FormGroup,
  Validators,
} from '@angular/forms';
import { Router } from '@angular/router';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';

@Component({
  selector: 'app-forgot-password',
  templateUrl: './forgot-password.component.html',
  styleUrls: ['./forgot-password.component.scss'],
})
export class ForgotPasswordComponent {
  forgotPass = new FormGroup({
    email: new FormControl('', [ Validators.required]),
    // email: new FormControl('', [Validators.email, Validators.required]),
  });

  constructor(private router: Router, private userData: UserDataService) {}
   id = localStorage.getItem('');
  ngOnInit(): void {}



all:any=[]
check:boolean = false
  onSubmit() {
    let inpData = this.forgotPass.value;
    console.log(inpData);

    this.userData
      .callApi(
        inpData,
        VariableConstants.METHOD_POST,
        RequestMapper.API_FORGOT_PASSWORD+"?email="+inpData.email,
        VariableConstants.ACCESS_PUBLIC
      )
      .subscribe((res:any)=>{
        
  
        this.all = res;
console.log(this.all.body.message);
console.log("=================================");
console.log(this.all.body.data)
if(this.all.body.code=='200'){
this.check = true
 
}else{
  alert('Error');
  this.check = false
}
      });
  }
  // {
  //   next: (res) => {
  //
  //     alert("test")
  //     console.log(res);
  //   },
  //   error: (err) => {
  //     console.log(err);
  //   },
  // }
  // this.redirecttodashboard();



  





  getControl(name: any): AbstractControl | null {
    return this.forgotPass.get(name);
  }

  redirect() {
    this.router.navigate(['/signup']);
  }

  // redirect() {
  //   this.router.navigate(['/' + RequestMapper.LOGIN]);
  // }


  login_redirect() {
    this.router.navigate(['/' + RequestMapper.LOGIN]);
  }
}
