import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import { ToastrService } from 'ngx-toastr';

import { ActivatedRoute, Router } from '@angular/router';
import {
  AfterViewChecked,
  DebugNode,
  ElementRef,
  EventEmitter,
  Input,
  Output,
  ViewChild,
} from '@angular/core';
@Component({
  selector: 'app-task-create',
  templateUrl: './task-create.component.html',
  styleUrls: ['./task-create.component.scss'],
})
export class TaskCreateComponent implements OnInit {
  @Output() messageEvent = new EventEmitter<string>();
  constructor(
    private userData: UserDataService,
    private toastr: ToastrService,
    private router: Router,
    private route: ActivatedRoute
  ) {}

  class_id_get: any;
  module_name_get: any;
  start_time_get: any;
  taskMode: boolean = false;
  form = new FormGroup({
    task_title: new FormControl('', [Validators.required]),
    task_issue: new FormControl(''),
    description: new FormControl('', [Validators.required]),
    task_date: new FormControl(''),
    status: new FormControl(''),
    
    class_id: new FormControl(''),
    module_name: new FormControl(''),
    start_time: new FormControl(''),
  });
  ngOnInit(): void {
    this.route.params.subscribe((params) => {
      // Access the parameters using params object
      this.class_id_get = params['class_id_get']; // Assuming 'id' is a parameter in the URL
      this.module_name_get = params['module_name_get'];
      this.start_time_get = params['start_time_get'];
      if (this.class_id_get && this.module_name_get && this.start_time_get) {
        this.taskMode = true;
        this.form.patchValue(
          {
            class_id : this.class_id_get,
            module_name : this.module_name_get,
            start_time : this.start_time_get
          }
        )
      }
      //console.log('ID:', id);
    });

    this.toastr.success('Author Deleted');
  }
  res_msg: any;
  rc_false_status:boolean=false;
  rc_status:boolean=false;
  submitForm() {
    if (
      this.form.get('task_issue') &&
      this.form.get('task_issue')?.value !== 'other'
    ) {
      this.form.controls['task_title'].setValue(
        this.form.get('task_issue')?.value || ''
      );
    }
    if (this.form.invalid) {
      return;
    }
    let dateToday = new Date().toDateString();
    let status = '1';
    this.form.controls['task_date'].setValue(dateToday);
    this.form.controls['status'].setValue(status);
    let inpData = this.form.value;
    // inpData.push(dateToday)
    if (this.form.valid) {
      console.log(this.form.value);
      inpData = this.form.value;
    }

    this.userData
      .callApi(
        inpData,
        VariableConstants.METHOD_POST,
        RequestMapper.API_CREATE_TASK,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
console.log(result)
        setTimeout(() => {
          if (result.body.code == '200') {
            this.res_msg = result.body.message;
            this.messageEvent.emit(this.res_msg);
            this.rc_status = true;
          } else if (result.body.code == '203') {
     
            this.res_msg = result.body.message;
            this.messageEvent.emit(this.res_msg);
            this.rc_false_status = true;
          } else {
            this.res_msg = result.body.message;
            this.messageEvent.emit(this.res_msg);
            this.rc_false_status = true;
          }
          setTimeout(() => {
            this.res_msg = ''; 
            this.rc_false_status = false;
            this.rc_status = false;
           this.router.navigate(['/portal/students/support']);
        }, 3000);
        }, 3000);


        // this.courseLevel = result.data;
        // setTimeout(() => {
        //   this.router.navigate(['/portal/students/support']);
        // }, 2000);
        // console.log(result);
        // if (result.code == 200) {
        //   this.toastr.success('Author Deleted');
        //   setTimeout(() => {
        //     this.router.navigate(['/portal/students/support']);
        //   }, 2000);
        // }
      });
  }

  
  selectedValue: string = '';
  msg_box: boolean = false;
  onSelectChange(event: any) {
    // Retrieve the selected value
    this.selectedValue = event.target.value;
    if (this.selectedValue == 'other') {
      this.msg_box = true;
    } else {
      this.msg_box = false;
    }
    console.log(this.selectedValue);
  }
}
