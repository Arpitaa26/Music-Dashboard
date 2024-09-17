import { Component, OnDestroy, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import {
  apply_filter,
  course,
  CourseEnrollmentInterface,
  course_level,
  HomeworkTeachersNote,
  ScheduleClassInterface,
} from '../homework-teachers-note/interface/homework-teachers-note';
import { HomeworkTeachersNoteModel } from '../homework-teachers-note/model/homework-teachers-note-model';
import { Assignments } from '../interface/assignments';
import { AssignmentsMenu } from '../model/assignments';
import { AssignmentService } from '../services/assignments-service.service';

@Component({
  selector: 'app-assignments',
  templateUrl: './assignments.component.html',
  styleUrls: ['./assignments.component.scss'],
})
export class AssignmentsComponent implements OnInit {
  courseFilterForm = new FormGroup({
    item: new FormControl(null, [Validators.required]),
    course_level_id: new FormControl(''),
  });
  usertype = new FormGroup({
    home_work: new FormControl('', [Validators.required]),
  });
  usertypedata = new FormGroup({
    teacher_note: new FormControl('', [Validators.required]),
  });
  msg: any;
  assignmnetsMenu: Assignments[] = AssignmentsMenu.menuMethod;
  courseSelection: any;

  constructor(
    private userData: UserDataService,
    private assignmentApiService: AssignmentService
  ) {}
  courseslist: undefined | null | course;
  course_level: undefined | null | course_level;
  CourseEnrollmentInterface: null | undefined | CourseEnrollmentInterface;
  tempModel: HomeworkTeachersNote[] = HomeworkTeachersNoteModel.methodHtnl;
  scheduleList: undefined | null | ScheduleClassInterface;
  CourseEnrollment: any;
  CourseEnrollment_uniq: any = [];
  courseLevel: any;
  courseLevel_unique: any = [];
  ngOnInit(): void {
    let users_id = localStorage.getItem('user_id');
    var classObj = this;

    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_COURSE_ENROLLMENT,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        console.log(result);
        this.CourseEnrollment = result;
        var uniquelist: any = [];

        this.CourseEnrollment!.data.forEach(function (data: any) {
          if (!uniquelist[data.course_name]) {
            uniquelist[data.course_name] = 1;
            classObj.CourseEnrollment_uniq.push(data);
          }
        });
      });
  }

  // show_popup: boolean = false;
  // details_popup() {
  //   // alert(this.show_popup)
  //   this.show_popup = !this.show_popup;
  // }

  // close_popups() {
  //   this.show_popup = false;
  // }

  onCoursesAss() {
    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_COURSE_LEVEL,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.course_level = result;
        console.log(this.course_level?.data);
      });
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
          this.msg = 'Batch Code found';
        } else {
          this.msg = '';
        }
      });
  }

  levels_uniq: any = [];
  lavels: any = [];
  all_level: any;
  onChangeCourse() {
    // debugger
    // var classObj = this;
    // this.courseLevel_unique = [];
debugger
    const courseSelected = this.courseFilterForm.value as any;
    if (courseSelected) {
      let course_id = courseSelected.item.split(',')[0];
      let batch_id = courseSelected.item.split(',')[1];
      this.assignmentApiService.setAssignMentId({
        course_id,
        batch_id,
      });
    }

    // let cr_id =  this.assignmentApiService.assignmentCourseId.next({course_id});

    // + '?course_id=' + course_Id
    //     this.userData
    //       .callApi(
    //         {},
    //         VariableConstants.METHOD_GET,
    //         RequestMapper.API_COURSE_ENROLLMENT ,
    //         VariableConstants.ACCESS_PRIVATE
    //       )
    //       .subscribe((result: any) => {
    //         this.lavels = [];
    //         console.log(result);
    //         this.courseLevel = result;
    //         var uniquelist: any = [];

    //         this.courseLevel!.data.forEach(function (data: any) {
    //           classObj.courseLevel_unique.push(data);
    //         });
    //         this.lavels = this.courseLevel_unique;
    //         console.log("==================================================" )
    //         console.log(this.lavels);
    //         this.lavels_name = Object.keys(this.lavels).map((key) => ({level:this.lavels[key].level}));

    //         const uniqueSet = new Set(this.lavels_name.map((obj: { level: any; }) => obj.level));
    //     const uniqueArray_for_type = Array.from(uniqueSet, level => this.lavels.find((obj: { level: any; }) => obj.level === level));
    //         console.log(uniqueArray_for_type)
    // this.all_level=uniqueArray_for_type;
    //   //this.course_level_id = Object.keys(this.all_courses).map((key) => ({course_level_id:this.all_courses[key].course_level_id}));
    //       });
  }


}
