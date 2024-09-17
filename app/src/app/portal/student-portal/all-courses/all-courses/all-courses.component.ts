import { Component } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router, RouterLink } from '@angular/router';
import { CourseListModel } from 'src/app/course-all/model/courseListModel';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';

@Component({
  selector: 'app-all-courses',
  templateUrl: './all-courses.component.html',
  styleUrls: ['./all-courses.component.scss'],
})
export class AllCoursesComponent {
  [x: string]: any;
  courseList: any = CourseListModel.returnMethod;
  all_courses: any;
  user_id: any;
  ult: any;
  other: any;
  type: any;
  level: any;
  uniqueArray: any;
  c_name: any;
  course_id: any;
  course_level_id: any;
  objID: any;
  selectname: any;
  cousre_id: any;
  constructor(
    private userData: UserDataService,
    private router: Router,
    private fb: FormBuilder
  ) {}
  CourseEnrollment_uniq: any = [];

  ngOnInit(): void {
    var classObj = this;

    //   .callApi(
    //     {},
    //     VariableConstants.METHOD_GET,
    //     RequestMapper.API_COURSE,
    //     VariableConstants.ACCESS_PRIVATE
    //   )
    //   .subscribe((result: any) => {
    //     console.log(result.data);
    //   });

    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_COURSE_ALL,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result) => {
        this.all_courses = result.data;
        console.log(this.all_courses);
        console.log('===================================================');
        //alert(typeof this.all_courses);  type
        this.user_id = localStorage.getItem('user_id');
        this.course_id = Object.keys(this.all_courses).map((key) => ({
          course_id: this.all_courses[key].course_id,
        }));
        this.course_level_id = Object.keys(this.all_courses).map((key) => ({
          course_level_id: this.all_courses[key].course_level_id,
        }));
        this.ult = Object.keys(this.all_courses).map((key) => ({
          course_id: this.all_courses[key].course_id,
          value: this.all_courses[key].name,
        }));
        this.other = Object.keys(this.all_courses).map((key) => ({
          level_id: this.all_courses[key].course_level_id,
          lavels: this.all_courses[key].level,
        }));
        this.type = Object.keys(this.all_courses).map((key) => ({
          session_type_id: this.all_courses[key].session_type_id,
          type: this.all_courses[key].type,
        }));
        console.log(this.course_level_id);
        console.log(this.course_id);
        this.mainArray = this.ult;
        this.lavel_array = this.other;
        //lavel

        const course_name_id = new Set(
          this.course_id.map((obj: { course_id: any }) => obj.course_id)
        );

        const uniqueArray_for_course_name_id = Array.from(
          course_name_id,
          (course_id) =>
            this.course_id.find(
              (obj: { course_id: any }) => obj.course_id === course_id
            )
        );
        this.course_id = uniqueArray_for_course_name_id;
        console.log(typeof uniqueArray_for_course_name_id);
        // name
        const course_name = new Set(
          this.ult.map((obj: { value: any }) => obj.value)
        );

        const uniqueArray_for_course_name = Array.from(course_name, (value) =>
          this.ult.find((obj: { value: any }) => obj.value === value)
        );
        this.c_name = uniqueArray_for_course_name;

        // Type array
        const uniqueSet = new Set(
          this.type.map((obj: { type: any }) => obj.type)
        );
        const uniqueArray_for_type = Array.from(uniqueSet, (type) =>
          this.type.find((obj: { type: any }) => obj.type === type)
        );

        //Lavel array
        const uniqueSet_lavel = new Set(
          this.lavel_array.map((objs: { lavels: any }) => objs.lavels)
        );
        const uniqueArray_for_lavel = Array.from(uniqueSet_lavel, (lavels) =>
          this.lavel_array.find((obj: { lavels: any }) => obj.lavels === lavels)
        );
        // ###############################
        // console.log(uniqueArray_for_lavel)
        // console.log("=============================");
        //     if (this.mainArray.length === this.lavel_array.length) {
        //       for (let i = 0; i < this.lavel_array.length; i++) {

        //         this.mainArray[i].lavel_array = this.lavel_array[i];
        //       }

        // console.log(this.mainArray)

        //     } else {
        //       console.error('Arrays must have the same length for key-wise pushing.');
        //     }
        // const index = this.c_name.indexOf(this.searchName);

        console.log(this.c_name);
        console.log(
          '==================================++++++++++++++++____________'
        );
        // this.c_name.forEach(function(ids:any) {
        //   console.log( uniqueArray_for_course_name_id );
        //   for (let i = 0; i < uniqueArray_for_course_name_id.length; i++) {

        //   }
        // });
        // console.log(this.c_name)
        this.mainArray.forEach((lavel: any) => {
          lavel.uniqueArray_for_lavel = uniqueArray_for_lavel;
        });

        const valuesArray = Object.keys(uniqueArray_for_course_name_id).map(
          (key) => uniqueArray_for_course_name_id
        );
        console.log(valuesArray);
        // this.mainArray.forEach((id:any) => {
        //   id.uniqueArray_for_course_name_id = uniqueArray_for_course_name_id;
        // });
        this.mainArray.forEach((type: any) => {
          type.uniqueArray_for_type = uniqueArray_for_type;
          const uniqueMap = new Map();
          // this.uniqueArray = type.type.filter((obj: { id: any; }) => {
          //   if (!uniqueMap.has(obj.id)) {
          //     uniqueMap.set(obj.id, true);
          //     return true;
          //   }
          //   return false;
          // });
        });

        // console.log(this.uniqueArray)

        //const jsonObject = JSON.parse(this.course_id);
        this.objID = Object.values(this.course_id);
        console.log(this.objID);
        // if (this.c_name.length === this.objID.length) {

        //     this.c_name.forEach((id:any) => {
        //       for (let i = 0; i < this.c_name.length; i++) {
        //        id.uniqueArray_for_course_name_id= uniqueArray_for_course_name_id[i];
        //      // id = this.objID[i];
        //     }

        //     });
        //     // const newItem = {
        //     //   id: uniqueArray_for_course_name_id[i],
        //     //   name:this.c_name[i]
        //     // };

        //     // this.c_name.push(newItem);

        // }
        console.log(this.c_name);
        // ===================================================================
      });
  }

  mainArray: any = [];
  lavel_array: any = [];
  res: any = [];

  enroll_class(data: any) {
    console.log(data);
    this.userData
      .callApi(
        data,
        VariableConstants.METHOD_POST,
        RequestMapper.API_COURSE_ENROLL,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.res = result;

        if (result.status == '200') {
          alert('course enrolled successfully');
        } else if (result.status == '203') {
          alert('Courses is All ready Enroll');
        }
      });
  }
  response_data: any;
  response_datas: any;
  gsmVal: any;
  gsmQuantVal: any;
  onSubmit(data: any) {
    this.gsmQuantVal = data;

    if (data.lavel && data.type) {
      this.router.navigate([
        'portal/students/all_courses/courses_buys/',
        data.course_id,
        data.lavel,
        data.type,
      ]);
    }
  }

  selectedValue: any;
  openIt(item: any) {
    console.log(item);
  }
}
