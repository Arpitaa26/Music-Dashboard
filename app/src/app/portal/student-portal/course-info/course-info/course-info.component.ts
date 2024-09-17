import { Component, OnInit, Output } from '@angular/core';
import {
  CourseListApiData,
  CourseListApiObj,
} from 'src/app/ConstantInterface/courseListApiInterface';
import { RequestMapper } from 'src/app/request-mapper';

import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import { CourseEnrollmentInterface } from '../interface/courseListInterface';

@Component({
  selector: 'app-course-info',
  templateUrl: './course-info.component.html',
  styleUrls: ['./course-info.component.scss'],
})
export class CourseInfoComponent implements OnInit {
  // courseList: CourseListApiObj;
  courseList: any;
  courseName: string = '';
  courseDesc: string = '';
  base_url:any;
  // @Output() moduleList: any;
  constructor(private userData: UserDataService) {
    this.courseList = [];
    // this.moduleList = [];
  }
  CourseEnrollmentInterface:any;
  courseListAllCourseEnrollmentInterface_uniq:any;
  
  ngOnInit(): void {
    this.base_url = 'https://thesvpacademy.com/admin/file/open/';

    let user_ids = localStorage.getItem('user_id');
      //Enrollment API get call
      // var classObj = this;
      this.userData.callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_COURSE_ENROLLMENT+"?user_id="+user_ids,
        VariableConstants.ACCESS_PRIVATE
      ).subscribe((res:any)=>{
        this.CourseEnrollmentInterface = res;
        // var uniquelist:any = [];
        // this.CourseEnrollmentInterface.data!.forEach(function (data:any) {
        //   if (!uniquelist[data.course_id]) {
        //     uniquelist[data.course_id]=1;
        //     classObj.courseListAllCourseEnrollmentInterface_uniq.push(data);
        //   }
             
        // });
        console.log(this.courseListAllCourseEnrollmentInterface_uniq);
      });


  }









  moduleGet(txt: string) {
    console.log(txt);
    // alert(this.courseDesc);
    // localStorage.setItem('course_name', this.courseName);
    // localStorage.setItem('course_long_desc', this.courseDesc);
  }
}
