import { Component } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { summaryModel } from 'src/app/portal/student-portal/class-details/summary/summary-model';
import { course_name } from 'src/app/portal/student-portal/class-details/summary/summary/summary.component';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';

import {
  ISchedule,
  IScheduleResponse,
} from '../Interface/studentListInterface';
import {
  AfterViewChecked,
  DebugNode,
  ElementRef,
  EventEmitter,
  Input,
  OnInit,
  Output,
  ViewChild,
} from '@angular/core';
import { SummaryService } from '../summary.service.ts/summary.service';
import {
  apply_filter,
  ScheduleClassInterface,
  TeacherSummaryInterface,
} from '../teacher-summary-interface';

@Component({
  selector: 'app-summary',
  templateUrl: './summary.component.html',
  styleUrls: ['./summary.component.scss'],
})
export class SummaryComponent {
  @Output() messageEvent = new EventEmitter<string>();
  usertype = new FormGroup({
    home_work: new FormControl('', [Validators.required]),
  });
  usertypedata = new FormGroup({
    teacher_note: new FormControl('', [Validators.required]),
  });
  course_filter = this.fb.group({
    user_selected: [null,Validators.required]
    // course_id: new FormControl(''),
    // course_level_id: new FormControl(''),
    // batch_id: new FormControl(''),
  });

  // courseslist:undefined|null|course;
  // course_level:undefined|null|course_level;
  courseslist: any;
  course_level: any;
  selectedValue: any;

  options: any;

  scheduleList: ISchedule[] = [];
  apply_filter: null | undefined | apply_filter;
  batch_id: any = [];

  crose_icon: boolean = true;

  subject: any = [];
  selectedOption: any = [];
  subject_uniq: any = [];
  subject_uniqs: any = [];
  // selectedValue= new FormGroup({
  //   studentname: new FormControl('')
  // })
  teacherSummaryInterface: any = [];
  teacherSummaryInterfaceUnique: any = [];

  constructor(
    private userData: UserDataService,
    private summaryApiService: SummaryService,
    private fb :FormBuilder,
    private router: ActivatedRoute,
    private routerPath: Router,
    private summaryservice: SummaryService,
  ) {}

  summaryList = summaryModel.returnMethod;
  ngOnInit(): void {
    var classObj = this;

    this.summaryApiService
      .getAllCourse()
      .subscribe((result: IScheduleResponse) => {
        this.teacherSummaryInterface = result.data;
        console.log(this.teacherSummaryInterface);
        console.log('==================================================');
        var uniquelist: any = [];
        console.log(this.teacherSummaryInterface);
        // this.teacherSummaryInterface!.forEach(function (item: any) {
        //   if (!uniquelist[item.user_id]) {
        //     uniquelist[item.user_id] = 1;
        //     classObj.teacherSummaryInterfaceUnique.push(item);
        //   }
        // });

        // console.log(this.teacherSummaryInterfaceUnique);
      });

    this.subject = '';
  }
  sortedItems(): { user_fullname: any,course_name:any,id:any }[] {
    return this.teacherSummaryInterface.slice().sort((a: { user_fullname: string,course_name:string }, b: { user_fullname: any,course_name:any }) => a.user_fullname.localeCompare(b.user_fullname));
  }
  
  redirectToSupport(data:any) {
 
     this.routerPath.navigate([
      '/portal/teachers/support/task-create/',
      data.id,
      data.module_name,
      data.start_time,
    ]);
  }
  getAllSummaryList() {
    this.summaryApiService.getAllCourse().subscribe((result: any) => {
      this.teacherSummaryInterface = result;
    });
  }
  show_popup: boolean = false;
  show_active: any;
  details_popup(id: any) {
    if (id) {
      this.show_popup = true;
      this.show_active = id;
    }
    // alert(this.show_popup)
  }
  close_popups() {
    this.show_active = '';
  }

  // filter api schedule class get all

  onSelectStudent() {
    if (this.course_filter.invalid) {
      return;
    }
    const { batch_id , user_id } = this.teacherSummaryInterface.find((el:any ) => el.id === this.course_filter.value.user_selected);
    this.summaryApiService
      .getAllSchedule(batch_id)
      .subscribe((result: IScheduleResponse) => {
        this.scheduleList = result.data;
      });
  }

  onUserChange(selectedValue: any): void {
  
    this.selectedOption = selectedValue.target.value;
    var classObj = this;
    // Do something with the selected value
    console.log(this.selectedOption);

    this.summaryApiService
      .getCourseById(this.selectedOption)
      .subscribe((result: any) => {
        this.subject = result;
        this.scheduleList = [];
        this.subject_uniqs = [];
      
        var classObjs = this;
        // this.subject = null;
        var uniquelists: any = [];
        classObjs.subject_uniqs = [];

        this.subject?.data.forEach(function (item: any) {
          if (!uniquelists[item.course_name]) {
            uniquelists[item.course_name] = 1;

            classObjs.subject_uniqs.push(item);
            console.log(classObjs.subject_uniqs);
          } else {
          }
        });
      });
    // this.applyfilter;
  }
  onCourseChange() {
    var classObj = this;
    // this.subject = null;
    var uniquelist: any = [];
    classObj.subject_uniq = [];
    this.subject?.data.forEach(function (item: any) {
      if (!uniquelist[item.level]) {
        uniquelist[item.level] = 1;

        classObj.subject_uniq.push(item);
        console.log(classObj.subject_uniq);
      } else {
      }
    });
  }
  submitShow: boolean = false;
  res: any = [];
  res_msg: any;
  rc_false_status:boolean=false;
  rc_status:boolean=false;
  Ussermsg(id: any, data: any) {
    console.log(id);
    // console.log(this.classId.id)
    let formData: any = new FormData();
    console.log(data);
    this.userData
      .callApi(
        data,
        VariableConstants.METHOD_FILE_POST,
        RequestMapper.API_TEACHER_ASSIGNEMENT_NOTES_SUBMIT + id,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        console.log(result);
        this.res = result;
        setTimeout(() => {
        if (this.res.body.code == '200') {
          this.res_msg = this.res.body.message;
          this.messageEvent.emit(this.res_msg);
          this.rc_status = true;
        } else if (this.res.body.code == '203') {
          //console.log(this.res.status);
          this.res_msg = this.res.body.message;
          this.messageEvent.emit(this.res_msg);
          this.rc_false_status = true;
        } else {
          this.res_msg = this.res.body.message;
          this.messageEvent.emit(this.res_msg);
          this.rc_false_status = true;
        }
        setTimeout(() => {
          this.res_msg = ''; 
          this.rc_false_status = false;
          this.rc_status = false;
      }, 2000);
      }, 2000);
      });
  }
  Ussermsgdata(id: any, data: any) {
    console.log(id);
    // console.log(this.classId.id)
    let formData: any = new FormData();
    console.log(data);
    this.userData
      .callApi(
        data,
        VariableConstants.METHOD_FILE_POST,
        RequestMapper.API_TEACHER_ASSIGNEMENT_NOTES_SUBMIT + id,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        console.log(result);
        this.res = result;
        // if (this.res.body.code == '200') {
        //   this.res_msg = this.res.body.message;
        // } else if (this.res.body.code == '203') {
        //   //console.log(this.res.status);
        //   this.res_msg = this.res.body.message;
        // } else {
        //   this.res_msg = this.res.body.message;
        // }


        setTimeout(() => {
          if (this.res.body.code == '200') {
            this.res_msg = this.res.body.message;
            this.messageEvent.emit(this.res_msg);
            this.rc_status = true;
          } else if (this.res.body.code == '203') {
            //console.log(this.res.status);
            this.res_msg = this.res.body.message;
            this.messageEvent.emit(this.res_msg);
            this.rc_false_status = true;
          } else {
            this.res_msg = this.res.body.message;
            this.messageEvent.emit(this.res_msg);
            this.rc_false_status = true;
          }
          setTimeout(() => {
            this.res_msg = ''; 
            this.rc_false_status = false;
            this.rc_status = false;
        }, 3000);
        }, 3000);
      });
  }
}
