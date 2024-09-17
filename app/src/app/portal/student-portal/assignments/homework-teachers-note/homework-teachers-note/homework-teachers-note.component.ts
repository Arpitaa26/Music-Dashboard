import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import { ScheduleclassModel } from '../../../class-details/scheduleclass/model/scheduleclass-model';
import {
  ICourseTypeResponse,
  IScheduleItems,
  IScheduleItemsResponse,
} from '../../interface/assignments';
import { AssignmentService } from '../../services/assignments-service.service';
import {
  apply_filter,
  course,
  course_level,
  HomeworkTeachersNote,
  ScheduleClassInterface,
} from '../interface/homework-teachers-note';
import { HomeworkTeachersNoteModel } from '../model/homework-teachers-note-model';
import { takeLast } from 'rxjs/operators';
import { SummaryService } from 'src/app/portal/teacher-portal/class-details/summary/summary.service.ts/summary.service';
import { ActivatedRoute, Router } from '@angular/router';
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
  selector: 'app-homework-teachers-note',
  templateUrl: './homework-teachers-note.component.html',
  styleUrls: ['./homework-teachers-note.component.scss'],
})
export class HomeworkTeachersNoteComponent implements OnInit {
  courseFilterForm = new FormGroup({
    batch_id: new FormControl('', [Validators.required]),
    course_level_id: new FormControl(''),
  });
  isBatchIdSelect: boolean = false;
  usertype = new FormGroup({
    home_work: new FormControl('', [Validators.required]),
  });
  usertypedata = new FormGroup({
    teacher_note: new FormControl('', [Validators.required]),
  });
  msg: any;
  isLoadingCourseType: boolean = false;
  // method:any;
  // method = "get";
  constructor(
    private userData: UserDataService,
    private assignmentApiService: AssignmentService,
    private router: ActivatedRoute,
    private routerPath: Router,
    private summaryservice: SummaryService
  ) {
    // this.assignmentApiService
    //   .getAllCourse()
    //   .subscribe((result: ICourseTypeResponse) => {
    //     this.courseLevel = result.data;
    //     this.isLoadingCourseType = false;
    //     if (this.courseLevel.length) {
    //       this.courseFilterForm.controls['course_level_id'].setValue(
    //         this.courseLevel[0].id
    //       );
    //     }

    //     // this.getModuleByLevel(att_id, 0);
    //   });
    this.assignmentApiService.getAllCourse().subscribe((result) => {
      this.courseLevel = result.data;
      this.onSelectValue(result.data[0].id);
    });
  }

  onSelectValue(course_level_id: string): void {
    this.assignmentApiService.assignmentCourseId
      .subscribe(({ batch_id }) => {
        // debugger
        this.loading = true;
        this.selectedIndex = 0;
        this.isLoadingCourseType = false;
        this.courseFilterForm.patchValue({
          batch_id,
          course_level_id,
        });
        this.onChangeCourseType();
      });
  }

  courseslist: undefined | null | course;
  course_level: undefined | null | course_level;
  CourseEnrollmentInterface: null | undefined | CourseEnrollmentInterface;
  tempModel: HomeworkTeachersNote[] = HomeworkTeachersNoteModel.methodHtnl;
  CourseEnrollment: any;
  CourseEnrollment_uniq: any = [];
  courseLevel: any;
  courseLevel_unique: any = [];
  scheduleList: IScheduleItems[] = [];
  loading: boolean = false;
  selectedIndex: number = 0;
  ngOnInit(): void {}

  // show_popup: boolean = false;
  // details_popup() {
  //   // alert(this.show_popup)
  //   this.show_popup = !this.show_popup;
  // }

  // close_popups() {
  //   this.show_popup = false;
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
  null_msg: any;
  onChangeCourseType() {
    // this.scheduleList = [];
    this.loading = true;
    let { batch_id, course_level_id } = this.courseFilterForm.value;
    if (batch_id && course_level_id) {
      this.assignmentApiService
        .getAllSchedule(batch_id, course_level_id)
        .subscribe((result: IScheduleItemsResponse) => {
          this.scheduleList = result.data || [];
          this.null_msg = result.message;
          this.loading = false;
        });
    } else {
      this.null_msg = 'Schedule class not found';
      this.loading = false;
      this.scheduleList = [];
    }
    //console.log(result.data);
  }

  apply_filter: null | undefined | apply_filter;
  batch_id_src: any = [];
  lavels_name: any;
  res_msg: any;
  applyfilter(data: any) {
    // data = {course_id: String, course_level_id: String}
    console.log(data);
    // schedule class with batch id

    this.userData
      .callApi(
        {
          // "from":this.currentDate + " 00:00:00",
          // "to":this.currentDate + " 23:59:59"
        },
        VariableConstants.METHOD_GET,
        RequestMapper.API_CLASS_SCHEDULE_GET_ALL +
          '?batch_id=' +
          data.course_id,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.scheduleList = result;
        if (data.course_id == 'null') {
          //alert("Batch Codet found")
          this.msg = 'Batch Codet found';
        } else {
          this.msg = '';
        }
      });
  }
  levels_uniq: any = [];
  lavels: any = [];
  all_level: any;
  changeWebsite(event: any) {
    let course_Id = event;
    var classObj = this;
    this.courseLevel_unique = [];

    console.log(course_Id);
    // + '?course_id=' + course_Id
    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_COURSE_ENROLLMENT,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.lavels = [];
        console.log(result);
        this.courseLevel = result;
        var uniquelist: any = [];

        this.courseLevel!.data.forEach(function (data: any) {
          classObj.courseLevel_unique.push(data);
        });
        this.lavels = this.courseLevel_unique;
        console.log('==================================================');
        console.log(this.lavels);
        this.lavels_name = Object.keys(this.lavels).map((key) => ({
          level: this.lavels[key].level,
        }));

        const uniqueSet = new Set(
          this.lavels_name.map((obj: { level: any }) => obj.level)
        );
        const uniqueArray_for_type = Array.from(uniqueSet, (level) =>
          this.lavels.find((obj: { level: any }) => obj.level === level)
        );
        console.log(uniqueArray_for_type);
        this.all_level = uniqueArray_for_type;
        //this.course_level_id = Object.keys(this.all_courses).map((key) => ({course_level_id:this.all_courses[key].course_level_id}));
      });
  }

  submitShow: boolean = false;
  res: any = [];

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
  close_popups() {
    this.show_active = '';
  }

  // getModuleByLevel(course_level_id: string) {
  //   this.loading = true;
  //   this.selectedIndex = course_level_id.toString();
  //   this.userData
  //     .callApi(
  //       { course_level_id, user_id:this.userId },
  //       VariableConstants.METHOD_GET,
  //       RequestMapper.API_TEACHER_COURSE_ENROLLMENT,
  //       VariableConstants.ACCESS_PRIVATE
  //     )
  //     .subscribe((result: any) => {
  //       this.courseName = result.data;
  //       console.log(this.courseName);
  //       this.loading = false;
  //     });
  // }

  redirectToSupport(data: any) {
    this.routerPath.navigate([
      '/portal/teachers/support/task-create/',
      data.id,
      data.module_name,
      data.start_time,
    ]);
  }
}
