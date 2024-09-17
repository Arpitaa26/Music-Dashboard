import { Component, OnInit } from '@angular/core';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import {
  FormGroup,
  FormControl,
  FormBuilder,
  Validators,
} from '@angular/forms';
export interface user_dtl {
  address: String;
  city: String;
  country: String;
  created_by: String;
  created_on: String;
  dob: String;
  email: String;
  first_name: String;
  full_name: String;
  id: String;
  ip: String;
  last_login: String;
  last_name: String;
  middle_name: String;
  no_of_referals: String;
  other_details: String;
  otp: String;
  phone_no: String;
  postal_code: String;
  pronoun: String;
  referal_code: String;
  state: String;
  status: String;
  type: String;
  updated_by: String;
  updated_on: String;
  user_pronoun_id: String;
  user_type_id: String;
  username: String;
  salary:string;
}
@Component({
  selector: 'app-teacher-profile',
  templateUrl: './teacher-profile.component.html',
  styleUrls: ['./teacher-profile.component.scss'],
})
export class TeacherProfileComponent implements OnInit {
  login_user_dtl: any = [];
  userUpdate: FormGroup;
  constructor(private userData: UserDataService, private fb: FormBuilder) {
    this.userUpdate = fb.group({
      full_name: new FormControl(''),
      address: new FormControl(''),
      email: new FormControl(''),
      id: new FormControl(''),
      username: new FormControl(''),
    });
  }
  total_salary:any;
  userHistory: undefined | null | user_dtl;
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

        // console.log(this.userHistory?.salary);
        // this.total_salary = this.userHistory?.salary;
        // console.log(this.userHistory?.address);
        // localStorage.setItem('Salary', this.total_salary);

      });

    this.update_ff_data = this.userHistory;
    console.log(this.update_ff_data.full_name);
    this.userUpdate = new FormGroup({
      full_name: new FormControl(this.update_ff_data.full_name),
      address: new FormControl(this.update_ff_data.address),
      email: new FormControl(this.update_ff_data.email),
      id: new FormControl(this.update_ff_data.id),
      username: new FormControl(this.update_ff_data.username),
    });
    this.userUpdate.setValue(this.update_ff_data.full_name);
    this.userUpdate.setValue({
      full_name: 'test',
    });
  }

  usernamee = localStorage.getItem('username');

  popup_show: boolean = false;
  update_popup() {
    this.popup_show = !this.popup_show;
  }
  close_update() {
    this.popup_show = false;
  }
  update_ff_data: any = [];
  updateUsser() {}
}
