import { Component } from '@angular/core';
import { FormBuilder, FormControl, FormGroup } from '@angular/forms';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';


export interface user_dtl{
  
address: String,
city: String,
country: String,
created_by: String,
created_on: String,
dob: String,
email: String,
first_name: String,
full_name: String,
id: String,
ip: String,
last_login: String,
last_name:String,
middle_name: String,
no_of_referals:String,
other_details: String,
otp: String,
phone_no: String,
postal_code: String,
pronoun: String,
referal_code: String,
state:String,
status:String,
type:String,
updated_by:String,
updated_on:String,
user_pronoun_id:String,
user_type_id:String,
username:String,
    


  
}

@Component({
  selector: 'app-student-profile',
  templateUrl: './student-profile.component.html',
  styleUrls: ['./student-profile.component.scss']
})
export class StudentProfileComponent {
 
  login_user_dtl: any=[];
  userUpdate:FormGroup;
  constructor(private userData:UserDataService,private fb:FormBuilder){
    this.userUpdate=fb.group({
      full_name: new FormControl(''),
      last_name:new FormControl(''),
      address: new FormControl(''),
      email: new FormControl(''),
      id: new FormControl(''),
      username: new FormControl(''),
      new_password: new FormControl(''),
    });
  }
  
  userHistory:undefined|null|user_dtl;
  ngOnInit(): void {
   
                this.userData
                .callApi(
                  {},
                  VariableConstants.METHOD_GET,
                  RequestMapper.API_USER_TYPE,
                  VariableConstants.ACCESS_PRIVATE
                )
                .subscribe((result: any) => {
                
                this.userHistory = result.data;
                
                console.log(this.userHistory)
            
                console.log(this.userHistory?.last_name);   
                // localStorage.setItem('userid', `${this.userHistory?.id}`);         
                  
                })



                this.update_ff_data=this.userHistory;
                console.log(this.update_ff_data.full_name);
                this.userUpdate=new FormGroup({
                  full_name: new FormControl(this.update_ff_data.full_name),
                  last_name: new FormControl(this.update_ff_data.last_name),
                  address: new FormControl(this.update_ff_data.address),
                  email: new FormControl(this.update_ff_data.email),
                  id: new FormControl(this.update_ff_data.id),
                  username: new FormControl(this.update_ff_data.username),
                  
                })
                this.userUpdate.setValue(this.update_ff_data.full_name);
                this.userUpdate.setValue(this.update_ff_data.last_name);
                this.userUpdate.setValue({
                 "full_name":'test'
                });
             
  }

  usernamee = localStorage.getItem('username');

  
  popup_show:boolean=false;
  update_popup(){
    this.popup_show=!this.popup_show;
  }
  close_update(){
    this.popup_show=false;
  }
  update_ff_data:any=[];
  updateUsser(data:any){
    console.log(data);
    let inpData = data.value;
    const updatedInpData = { ...inpData  };
    this.userData
    .callApi(
      updatedInpData,
      VariableConstants.METHOD_POST,
      RequestMapper.API_REGISTRATION,
      VariableConstants.ACCESS_PUBLIC
    )
    .subscribe((result: any) => {
      // next: (result: any) => {
      // this.login_text = '';
      // this.active_loader = true;
      console.log(result);

      setTimeout(() => {
        // if (result.body.code == 200) {
        //   this.st_msg = result.body.message;
        //   this.status_sucess = true;
        //   this.router.navigate([RequestMapper.LOGIN], {
        //     queryParams: { isVerify: true },
        //   });
        //   // status_error:boolean = false;
        //   // this.messageEvent.emit(this.st_msg);
        // } else if (result.body.code == 203) {
        //   //console.log(this.res.status);
        //   this.status_error = true;
        //   this.st_msg = result.body.message;
        //   this.messageEvent.emit(this.st_msg);
        // } else {
        //   this.status_error = true;
        //   this.st_msg = result.body.message;
        //   this.messageEvent.emit(this.st_msg);
        // }

        // if (result.status == 200) {
        //   this._toastService.generate({
        //     type: 'success', //<-- mandatory key
        //     toastHeading: 'Success', //<-- mandatory key
        //     toastText: 'User has been registered Successfully ', //<-- mandatory key
        //     timeout: 5000, //<-- non-mandatory key
        //     position: 'top-right', //<-- non-mandatory key
        //     autoClose: true, //<-- non-mandatory key
        //     progressbar: true, //<-- non-mandatory key
        //   });

        //   setTimeout(() => {
        //     this.redirect();
        //   }, 3000);
        // } else {
        //   this._toastService.generate({
        //     type: 'info',
        //     toastHeading: 'Error',
        //     toastText: 'Something went wrong ', //<-- mandatory key
        //     timeout: 5000, //<-- non-mandatory key
        //     position: 'top-right', //<-- non-mandatory key
        //     autoClose: true, //<-- non-mandatory key
        //     progressbar: true,
        //   });
        // }
        // },
        // error: (err) => {
        //   console.log(err);
        // },

        setTimeout(() => {
          //  debugger
          // this.status_error = false;
          // this.status_sucess = false;

          // this.st_msg = '';
          // debugger  /?message=Email verification pending
        }, 3000);
      });
    });
  }
}
