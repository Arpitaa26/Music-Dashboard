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
  base_url:any;
  slug:any;
  short_description: any;
  category_name:any;
  cr_cat:any;
  constructor(
    private userData: UserDataService,
    private router: Router,
    private fb: FormBuilder
  ) {}
  CourseEnrollment_uniq: any = [];
 card: any;
 show: boolean = true;
  ngOnInit(): void {

    this.base_url = 'https://thesvpacademy.com/admin/file/open/';
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

        //alert(typeof this.all_courses);  type
        this.user_id = localStorage.getItem('user_id');
        this.course_id = Object.keys(this.all_courses).map((key) => ({
          course_id: this.all_courses[key].course_id,

        }));
        this.slug = Object.keys(this.all_courses).map((key) => ({

          slug: this.all_courses[key].slug,
        }));
        this.course_level_id = Object.keys(this.all_courses).map((key) => ({
          course_level_id: this.all_courses[key].course_level_id,
        }));

        this.ult = Object.keys(this.all_courses).map((key) => ({
          course_id: this.all_courses[key].course_id,
          category: this.all_courses[key].category,
          value: this.all_courses[key].name,
          slug:this.all_courses[key].slug,
          short_description:this.all_courses[key].short_description,
          description:this.all_courses[key].description,
        }));
        this.category_name=Object.keys(this.all_courses).map((key)=>({
          category: this.all_courses[key].category,
        }))



        let tempObj:any = {};

        // Filter out duplicate categories
        let uniqueArray_category = this.category_name.filter((obj:any) => {
            return tempObj.hasOwnProperty(obj.category) ? false : (tempObj[obj.category] = true);
        });

        uniqueArray_category.push({ category: 'All' });
        this.cr_cat = uniqueArray_category;
        console.log(this.cr_cat);

        console.log('===================================================++++++++++++++++');












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
          this.course_id.map((obj: { course_id: any,slug:any },) => obj.course_id)
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
        const course_category = new Set(
          this.category_name.map((obj: { value: any }) => obj.value)
        );
        // const slug = new Set(
        //   this.ult.map((obj: { value: any }) => obj.value)
        // );

        const uniqueArray_for_course_name = Array.from(course_name, (value) =>
          this.ult.find((obj: { value: any }) => obj.value === value)
        );
        const uniqueArray_for_category = Array.from(course_category, (value) =>
          this.ult.find((obj: { value: any }) => obj.value === value)
        );



       console.log( this.category_name)
        this.c_name = uniqueArray_for_course_name;
        console.log(this.c_name)
        // Type array  cr_cat
        const uniqueSet = new Set(
          this.type.map((obj: { type: any }) => obj.type)
         // obj.type.replace('-', " ");
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
      this.activateAllCategories();
      this.filterCards('All',2) ;



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

        // if (result.status == '200') {
        //   alert('course enrolled successfully');
        // } else if (result.status == '203') {
        //   alert('Courses is All ready Enroll');
        // }
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
        'portal/students/course_info/all-courses',
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








  categories = ['Category1', 'Category2', 'Category3', 'All'];
  selectedCategory = 'All';
  cards = [
    { title: 'Card 1', description: 'Description 1', category: 'Category1' },
    { title: 'Card 2', description: 'Description 2', category: 'Category2' },
    { title: 'Card 3', description: 'Description 3', category: 'Category3' },
    { title: 'Card 4', description: 'Description 4', category: 'Category1' },
    { title: 'Card 5', description: 'Description 5', category: 'Category2' }
  ];
  filteredCards = this.cards;
  selectedCategoryIndex = 3;
  filterCards(category: string,index: any) {
    console.log(category,index)
    this.selectedCategory = category;
    this.selectedCategoryIndex = index;
  }
  activateAllCategories() {
    this.categories.forEach((_, index) => {
      this.selectedCategoryIndex = index;
      this.selectedCategory = this.categories[this.selectedCategoryIndex];
    });
  }

}
