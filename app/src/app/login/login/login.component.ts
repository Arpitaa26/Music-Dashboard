import { Component, OnInit } from '@angular/core';
import { EventEmitter, Output } from '@angular/core';
import { ActivatedRoute, Router, Routes } from '@angular/router';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import {
  FormGroup,
  FormControl,
  Validators,
  NgForm,
  AbstractControl,
} from '@angular/forms';
import { ToastrService } from 'ngx-toastr';
import { VariableConstants } from 'src/app/variable-contants';
import { BmxToastService } from 'bmx-toast';

export interface login {
  username: String;
  password: String;
}
export interface login_user_dtl {
  id: String;
  user_type_id: String;
  user_pronoun_id: String;
  first_name: String;
  middle_name: String;
  last_name: String;
  username: String;
  email: String;
  phone_no: String;
  city: String;
  state: String;
  country: String;
  postal_code: String;
  address: String;
  dob: String;
  otp: String;
  referal_code: String;
  no_of_referals: String;
  last_login: String;
  ip: String;
  created_by: String;
  updated_by: String;
  created_on: String;
  updated_on: String;
  full_name: String;
  type: String;
  pronoun: String;
  salary: String;
  currency: any;
}
@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss'],
})
export class LoginComponent implements OnInit {
  usersFrom = new FormGroup({
    username: new FormControl('', [Validators.required]),
    password: new FormControl('', [Validators.required]),
  });
  @Output() messageEvent = new EventEmitter<string>();
  login_user_dtl: null | undefined | login_user_dtl;
  login_text: string = '........';
  active_loader: boolean = false;
  login_color: string = '';
  error_msg: any = [];
  total_salary: any;
  currency: any;
  isVerify:boolean = false;
  st_msg: any;
  constructor(
    private router: Router,
    private userData: UserDataService,
    private toastr: ToastrService,
    public _toastService: BmxToastService,
    private _activateRoute:ActivatedRoute
  ) {
    this._activateRoute.queryParams.subscribe(params => {
      this.isVerify = params['isVerify'] as boolean;

      if(this.isVerify){
       // alert('Toater add')
        setTimeout(() => {
         
            this.st_msg = 'Please verify your email';
          
            this.messageEvent.emit(this.st_msg);
            // status_error:boolean = false;
            // this.messageEvent.emit(this.st_msg);
         
          setTimeout(() => {
            //  debugger
       

            this.st_msg = '';
            // debugger  /?message=Email verification pending
          }, 3000);
        });
      }
     
  });}

  
  getControl(name: any): AbstractControl | null {
    return this.usersFrom.get(name);
  }

  ngOnInit(): void {
    this.login_text = 'Login';
  }

  redirecttodashboard(val: string):void {
    this.router.navigate([
      //redirect to student
      RequestMapper.PORTAL +
        '/' +
        val +
        's' +
        '/' +
        RequestMapper.STUDENTS_DASHBOARD,
    ]);
    // this.router.navigate([
    //   //redirect to student
    //   RequestMapper.PORTAL +
    //     '/' +
    //     RequestMapper.STUDENT_PORTAL +
    //     '/' +
    //     RequestMapper.STUDENTS_DASHBOARD,
    // ]);
  }
  redirect():void {
    this.router.navigate(['/signup']);
  }
  redirectCourse():void {
    this.router.navigate(['/all_course']);
  }

  // login api
  getuserData():void {
    let data = this.usersFrom.value;
    if (
      this.usersFrom.controls['password'].value != '' &&
      this.usersFrom.controls['username'].value != ''
    ) {
      this.userData
        .callApi(
          data,
          VariableConstants.METHOD_POST,
          RequestMapper.API_USER_LOGIN,
          VariableConstants.ACCESS_PUBLIC
        )
        .subscribe(
          {
            next: (data) => {
              this.login_text = '';
              this.login_color = 'green';
              this.active_loader = true;
              this.toastr.success('LogIn Successful');
              //this.redirecttodashboard();

              if (data.status == 200) {
                localStorage.setItem('token', data.body.data['api-key']);
                this.userData
                  .callApi(
                    {},
                    VariableConstants.METHOD_GET,
                    RequestMapper.API_USER_TYPE,
                    VariableConstants.ACCESS_PRIVATE
                  )
                  .subscribe((result: any) => {
                    let data = result.data;
                    console.log(data);
                    let type = data.type.toLowerCase();
                    this.login_user_dtl = result.data;

                    this.redirecttodashboard(type);

                    console.log(this.login_user_dtl);

                    localStorage.setItem(
                      'user_id',
                      `${this.login_user_dtl?.id}`
                    );
                    localStorage.setItem(
                      'user_type_id',
                      `${this.login_user_dtl?.user_type_id}`
                    );
                    localStorage.setItem(
                      'user_pronoun_id',
                      `${this.login_user_dtl?.user_pronoun_id}`
                    );
                    localStorage.setItem(
                      'user_first_name',
                      `${this.login_user_dtl?.first_name}`
                    );
                    // localStorage.setItem(
                    //   'salary',
                    //   `${this.login_user_dtl?.salary}`
                    // );
                    localStorage.setItem(
                      'username',
                      `${this.login_user_dtl?.username}`
                    );

                    // localStorage.setItem(
                    //   'user_email_id',
                    //   `${this.login_user_dtl?.email}`
                    // );
                    // localStorage.setItem(
                    //   'user_phone_no',
                    //   `${this.login_user_dtl?.phone_no}`
                    // );
                    // localStorage.setItem(
                    //   'user_city',
                    //   `${this.login_user_dtl?.city}`
                    // );
                    // localStorage.setItem(
                    //   'user_state',
                    //   `${this.login_user_dtl?.state}`
                    // );
                    // localStorage.setItem(
                    //   'user_country',
                    //   `${this.login_user_dtl?.country}`
                    // );
                    // localStorage.setItem(
                    //   'user_postal_code',
                    //   `${this.login_user_dtl?.postal_code}`
                    // );
                    // localStorage.setItem(
                    //   'user_address',
                    //   `${this.login_user_dtl?.address}`
                    // );
                    // localStorage.setItem(
                    //   'user_dob',
                    //   `${this.login_user_dtl?.dob}`
                    // );
                    // localStorage.setItem(
                    //   'user_otp',
                    //   `${this.login_user_dtl?.otp}`
                    // );
                    // localStorage.setItem(
                    //   'user_referal_code',
                    //   `${this.login_user_dtl?.referal_code}`
                    // );
                    // localStorage.setItem(
                    //   'user_no_of_referals',
                    //   `${this.login_user_dtl?.no_of_referals}`
                    // );
                    // localStorage.setItem(
                    //   'user_ip',
                    //   `${this.login_user_dtl?.ip}`
                    // );
                    localStorage.setItem(
                      'user_full_name',
                      `${this.login_user_dtl?.full_name}`
                    );
                    localStorage.setItem(
                      'user_type',
                      `${this.login_user_dtl?.type}`
                    );

                    this.total_salary = this.login_user_dtl?.salary;
                    localStorage.setItem('Salary', this.total_salary);
                    this.currency = this.login_user_dtl?.currency;
                    localStorage.setItem('Currency', this.currency);
                    console.log(data.body.message);
                    console.log(this.total_salary);
                  });
              } else {
                setTimeout(() => {
         
                  this.st_msg = 'Please verify your email';
                
                  this.messageEvent.emit(this.st_msg);
                  // status_error:boolean = false;
                  // this.messageEvent.emit(this.st_msg);
               
                setTimeout(() => {
                  //  debugger
             
      
                  this.st_msg = '';
                  // debugger  /?message=Email verification pending
                }, 3000);
              });
              }
            },
            error: (err) => {
              console.log(err.error.message);
              this.error_msg = err.error.message;
              // alert(err.error.message);
              // this._toastService.generate({
              //   type: 'error', //<-- mandatory key
              //   toastHeading: 'Error', //<-- mandatory key
              //   toastText: err.error.message, //<-- mandatory key
              //   timeout: 5000, //<-- non-mandatory key
              //   position: 'top-right', //<-- non-mandatory key
              //   autoClose: true, //<-- non-mandatory key
              //   progressbar: true, //<-- non-mandatory key
              //   background: '#c43636',
              //   color: '#fffafa',
              // });
            },
            // this.redirecttodashboard();
          }
          // (err: Error) => {
          //   console.log(err);
          //   this.toastr.error('LogIn Failed');
          // }
        );
    } else {
      this._toastService.generate({
        type: 'info', //<-- mandatory key
        toastHeading: 'Error', //<-- mandatory key
        toastText: 'Please Enter All the fields', //<-- mandatory key
        timeout: 5000, //<-- non-mandatory key
        position: 'top-right', //<-- non-mandatory key
        autoClose: true, //<-- non-mandatory key
        progressbar: true, //<-- non-mandatory key
      });
    }

    // this.userData.loginUsers(data);
  }


}
