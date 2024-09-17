import { Component, OnInit } from '@angular/core';
import { summaryModel } from '../summary-model';
import {
  apply_filter,
  course_level,
  ICourseType,
  ICourseTypeResponse,
  IScheduleItems,
  IScheduleItemsResponse,
  ScheduleClassInterface,
  summaryInteface,
} from '../summary-interface';
import { course } from '../../../assignments/homework-teachers-note/interface/homework-teachers-note';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import { RequestMapper } from 'src/app/request-mapper';
import { ScheduleclassModel } from '../../scheduleclass/model/scheduleclass-model';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { CourseLevelInterface } from '../../../performance-report/interface/courseLevelInterface';
import { ClassDetailsService } from '../../services/summary.service';
import { SummaryService } from 'src/app/portal/teacher-portal/class-details/summary/summary.service.ts/summary.service';
import { ActivatedRoute, Router } from '@angular/router';

export interface course_name {
  data: [
    {
      id: String;
      code: String;
      name: String;
      role: String;
      price: String;
      description: String;
    }
  ];
}
export interface CourseEnrollmentInterface {
  data: [
    {
      id: string;
      user_id: string;
      course_id: string;
      course_level_id: string;
      batch_id: string;
      category: string;
      referral_code_used: string;
      modules_completed: string;
      attendance: string;
      classes_purchased: string;
      classes_used: string;
      status: string;
      created_by: string;
      updated_by: string;
      created_on: string;
      updated_on: string;
      user_fullname: string;
      course_name: string;
      batch_code: string;
      level: string;
    }
  ];
}
@Component({
  selector: 'app-summary',
  templateUrl: './summary.component.html',
  styleUrls: ['./summary.component.scss'],
  // providers: [
  //   summaryModel
  // ]
})
export class summaryComponent implements OnInit {
  courseFilterForm = new FormGroup({
    course_id: new FormControl('', [Validators.required]),
    course_level_id: new FormControl(''),
  });
  usertype = new FormGroup({
    home_work: new FormControl('', [Validators.required]),
  });
  usertypedata = new FormGroup({
    teacher_note: new FormControl('', [Validators.required]),
  });

  course_name: undefined | null | course_name;
  course_level: undefined | null | course_level;
  CourseEnrollmentInterface: null | undefined | CourseEnrollmentInterface;
  constructor(
    private userData: UserDataService,
    private classDetailsServiceApi: ClassDetailsService,
    private router: ActivatedRoute,
    private routerPath: Router,
    private summaryservice: SummaryService
  ) {}

  summaryList = summaryModel.returnMethod;
  //scheduleList: ScheduleClassInterface[] = ScheduleclassModel.returnMethod;
  scheduleList: IScheduleItems[] = [];
  CourseEnrollment: ICourseType[] = [];
  datas: any;
  CourseEnrollment_uniq: any = [];

  courseLevel: ICourseType[] = [];
  courseName: any;
  selectedIndex: number = 0;
  loading: boolean = true;
  isLoadingCourseType: boolean = true;
  ngOnInit(): void {
    console.log(this.summaryList);

    let users_id = localStorage.getItem('user_id');
    var classObj = this;
    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_COURSE_ENROLLMENT,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: ICourseTypeResponse) => {
        this.CourseEnrollment = result.data;
        // this.datas = this.removeDuplicates(this.CourseEnrollment.data);
        var uniquelist: any = [];

        this.CourseEnrollment.forEach(function (data: any) {
          if (!uniquelist[data.course_name]) {
            uniquelist[data.course_name] = 1;
            classObj.CourseEnrollment_uniq.push(data);
          }
        });
        console.log(classObj.CourseEnrollment_uniq);
        console.log(
          '===================================================================='
        );

        localStorage.setItem(
          'batch_id',
          `${this.CourseEnrollment[3].batch_id}`
        );
      });

    // schedule class get all api
    // let batch_id=localStorage.getItem('batch_id');
    // this.userData
    //         .callApi(
    //           {

    //           },
    //           VariableConstants.METHOD_GET,
    //           RequestMapper.API_CLASS_SCHEDULE_GET_ALL,
    //           VariableConstants.ACCESS_PRIVATE
    //         )
    //         .subscribe((result: any) => {
    //           this.scheduleList = result?.data;
    //           console.log(this.scheduleList[0].id)
    //           localStorage.setItem('batch_id', `${this.scheduleList[0].batch_id}`);

    //         });
    this.classDetailsServiceApi
      .getAllCourse()
      .subscribe((result: ICourseTypeResponse) => {
        this.courseLevel = result.data;
        this.isLoadingCourseType = false;
        if (this.courseLevel.length)
          this.courseFilterForm.controls['course_level_id'].setValue(
            this.courseLevel[0].id
          );

        // this.getModuleByLevel(att_id, 0);
      });
  }

  // sortedItems(): { user_fullname: any; course_name: any; id: any }[] {
  //   return this.CourseEnrollment_uniq
  //     .slice()
  //     .sort(
  //       (
  //         a: { user_fullname: string; course_name: string },
  //         b: { user_fullname: any; course_name: any }
  //       ) => a.user_fullname.localeCompare(b.user_fullname)
  //     );
  // }

  getModuleByLevel(id: string, index: number) {
    this.selectedIndex = index;
    this.courseFilterForm.controls['course_level_id'].setValue(id);
    this.onChangeCourseType();
    // this.userData
    //   .callApi(
    //     { course_level_id: id },
    //     VariableConstants.METHOD_GET,
    //     RequestMapper.API_TEACHER_COURSE_ENROLLMENT,
    //     VariableConstants.ACCESS_PRIVATE
    //   )
    //   .subscribe((result: any) => {
    //     this.courseName = result.data;

    //     console.log(this.courseName);
    //     this.loading = false;
    //   });
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
  // removeDuplicates(inputArray: any[]): any[] {
  //   return inputArray.filter((item, index, array) => array.indexOf(item) === index);
  // }
  batch_id: any = [];
  apply_filter: null | undefined | apply_filter;
  msg: any;

  onChangeCourse() {
    this.selectedIndex = 0;
    if (this.courseFilterForm.invalid) {
      return;
    }
    this.onChangeCourseType();
  }

  onChangeCourseType() {
    this.scheduleList = [];
    this.loading = true;
    let { course_id, course_level_id } = this.courseFilterForm.value;
    this.loading = true;
    if (course_id && course_level_id) {
      this.classDetailsServiceApi
        .getAllSchedule(course_id, course_level_id)
        .subscribe((result: IScheduleItemsResponse) => {
          this.scheduleList = result.data || [];
          this.loading = false;
        });
    }
  }

  levels_uniq: any = [];
  lavels: any = [];
  // changeWebsite() {
  //   var classObj = this;
  //   this.lavels = this.CourseEnrollment;
  //   var uniquelist: any = [];
  //   classObj.levels_uniq = [];

  //   this.lavels!.data.forEach(function (data: any) {
  //     if (!uniquelist[data.level]) {
  //       uniquelist[data.level] = 1;
  //       classObj.levels_uniq.push(data);
  //     }
  //   });
  // }

  submitShow: boolean = false;
  res: any = [];
  res_msg: any;
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

  redirectToSupport(data: any) {
    this.routerPath.navigate([
      '/portal/teachers/support/task-create/',
      data.id,
      data.module_name,
      data.start_time,
    ]);
  }
}
