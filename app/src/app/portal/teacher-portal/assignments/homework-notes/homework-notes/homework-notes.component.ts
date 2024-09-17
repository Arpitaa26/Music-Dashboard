import { Component, OnInit } from '@angular/core';

import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import { RequestMapper } from 'src/app/request-mapper';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { apply_filter } from '../homework-notes-interface';
import { ActivatedRoute, Params, Router } from '@angular/router';
import { CommomServiceService } from 'src/app/services/commom-service.service';
import {
  AfterViewChecked,
  DebugNode,
  ElementRef,
  EventEmitter,
  Input,

  Output,
  ViewChild,
} from '@angular/core';
import {
  ISchedule,
  IScheduleResponse,
} from '../../../class-details/summary/Interface/studentListInterface';

@Component({
  selector: 'app-homework-notes',
  templateUrl: './homework-notes.component.html',
  styleUrls: ['./homework-notes.component.scss'],
})
export class HomeworkNotesComponent implements OnInit {
  @Output() messageEvent = new EventEmitter<string>();
  usertype = new FormGroup({
    home_work: new FormControl('', [Validators.required]),
  });
  usertypedata = new FormGroup({
    teacher_note: new FormControl('', [Validators.required]),
  });
  course_filter = new FormGroup({
    course_id: new FormControl(''),
    course_level_id: new FormControl(''),
  });

  CourseEnrollment: any = '';
  scheduleList: ISchedule[] = [];
  studentId: any = '';
  subject_uniq: any = [];
  StudentuserId: string = '';
  constructor(
    private userData: UserDataService,
    private activatedRoute: ActivatedRoute,
    private commonService: CommomServiceService,
    private router: ActivatedRoute,
    private routerPath: Router,
  ) {}

  ngOnInit(): void {
    // this.StudentuserId = localStorage.getItem('Assignment_Student_id')!;
    // this.getBatchId();

    this.activatedRoute.queryParams.subscribe((queryParams: Params) => {
      //Should display { debug: true} object
      console.log(queryParams);
    });

    this.commonService.assignmentStudentId.subscribe((data: any) => {
      const { batch_id, user_id } = data;
      // this.StudentuserId = id;
      this.scheduleList = [];
      this.allCourseName_uniq = [];
      this.singel_level = [];
      this.course_filter.reset();
      this.getBatchId(user_id);
      this.getInfo(batch_id);
    });

    // console.log(this.CourseEnrollment)
  }

  allCourseName_uniq: any = [];
  getBatchId(id: string) {
    var classObj = this;
    this.userData
      .callApi(
        {},

        VariableConstants.METHOD_GET,
        RequestMapper.API_TEACHER_COURSE_ENROLLMENT + '?user_id=' + id,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.CourseEnrollment = result;

        var uniquelist: any = [];
        this.CourseEnrollment!.data.forEach(function (data: any) {
          if (!uniquelist[data.course_name]) {
            uniquelist[data.course_name] = 1;
            classObj.allCourseName_uniq.push(data);
          }
        });
        console.log(this.CourseEnrollment);
      });
  }
  completedData: any[] | undefined;
  getInfo(batch_id: string) {
    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_CLASS_SCHEDULE_GET_ALL + '?batch_id=' + batch_id,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: IScheduleResponse) => {
        this.scheduleList = result.data;
        // console.log(this.scheduleList?.data)
        // this.allCourseName_uniq = [];
        // this.singel_level = [];
        this.completedData = this.scheduleList.filter(item => item.status === "COMPLETED");
      
        // console.log(this.completedData);
      });
  }
  // applyfilter(data: any) {
  //   this.userData
  //     .callApi(
  //       {},
  //       VariableConstants.METHOD_GET,
  //       RequestMapper.API_CLASS_SCHEDULE_GET_ALL +
  //         '?batch_id=' +
  //         this.CourseEnrollment.data[0].batch_id,
  //       VariableConstants.ACCESS_PRIVATE
  //     )
  //     .subscribe((result: IScheduleResponse) => {
  //       this.scheduleList = result.data;
  //       // console.log(this.scheduleList?.data)
  //       // this.allCourseName_uniq = [];
  //       // this.singel_level = [];
  //     });
  //   // localStorage.setItem('StudentId','');
  // }

  lavels: any = [];
  course_level: any;
  singel_level: any;
  changeWebsite() {
    var classObj = this;
    this.lavels = this.CourseEnrollment;
    //console.log(this.lavels);
    this.course_level = Object.keys(this.lavels?.data).map((key) => ({
      id: this.lavels?.data[key].id,
      level: this.lavels?.data[key].level,
    }));
    const course_level_id = new Set(
      this.course_level.map((obj: { level: any }) => obj.level)
    );

    const uniqueArray_for_course_level_id = Array.from(
      course_level_id,
      (level) =>
        this.course_level.find((obj: { level: any }) => obj.level === level)
    );
    this.singel_level = uniqueArray_for_course_level_id;
    console.log(uniqueArray_for_course_level_id);
    console.log(
      '=================================================================='
    );
    classObj.subject_uniq = [];
    var uniquelist: any = [];
    this.lavels?.data.forEach(function (data: any) {
      if (!uniquelist[data.course_name]) {
        uniquelist[data.level] = 1;
        classObj.subject_uniq.push(data);
        console.log(classObj.subject_uniq);
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
        }, 2000);
        }, 2000);


      });
  }
  Ussermsgdata(id: any, data: any) {
    console.log(id);
    console.log(data);
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
        console.log('=======================================================');
        this.res = result;
        if (this.res.body.code == '200') {
          this.res_msg = this.res.body.message;
        } else if (this.res.body.code == '203') {
          //console.log(this.res.status);
          this.res_msg = this.res.body.message;
        } else {
          this.res_msg = this.res.body.message;
        }
      });
  }

  show_popup: boolean = false;

  crose_icon: boolean = true;

  show_active: any;
  details_popup(id: any) {
    if (id) {
      this.show_popup = true;
      this.show_active = id;
    }
    // alert(this.show_popup)
  }

  redirectToSupport(data:any) {
 
    this.routerPath.navigate([
     '/portal/teachers/support/task-create/',
     data.id,
     data.module_name,
     data.start_time,
   ]);
 }


  close_popups() {
    this.show_active = '';
  }
}
