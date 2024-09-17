import { Component } from '@angular/core';
import { CourseListApiData } from 'src/app/ConstantInterface/courseListApiInterface';
import { CourseListModel } from 'src/app/portal/student-portal/course-info/model/courseListModel';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';


@Component({
  selector: 'app-course-info',
  templateUrl: './course-info.component.html',
  styleUrls: ['./course-info.component.scss'],
})
export class CourseInfoComponent {
  CourseEnrollmentInterface: any;

  constructor(private userData:UserDataService) {

    this.courseList = [];
  }
  courseList: any = CourseListModel.returnMethod;
  allStudentsInfo:any = [];
  studentId:any = '';
  courseListAll_uniq:any = [];
  moduleGet(item: any) {
    console.log(item);
  }

  base_url:any;
  courseListAll:any;
  resultss:any;
  status:any;
  ngOnInit(): void {
    this.getStudentsDetails();

    this.base_url = 'https://thesvpacademy.com/admin/file/open/';
     let user_ids = localStorage.getItem('user_id');
    var classObj = this;
    this.userData
    .callApi(
      {},
      VariableConstants.METHOD_GET,
      RequestMapper.API_COURSE_ENROLLMENT,
      VariableConstants.ACCESS_PRIVATE
    )
    .subscribe((result: CourseListApiData) => {
      this.courseListAll = result;
      this.resultss = result.data;
      this.status = result.code;
      console.log(this.courseListAll)

      var uniquelist:any = [];
      this.courseListAll.data!.forEach(function (data:[]|any|null) {
        if (!uniquelist[data.course_id]) {
          uniquelist[data.course_id]=1;
          classObj.courseListAll_uniq.push(data);
        }

      });

      console.log(this.courseListAll_uniq);

    });




  }

  hasNullValues(): boolean {
    return this.courseListAll_uniq.some((element: null) => element === null);
  }


//  new all course get alll













  allStudentsInfo_uniq:any =[]
  getStudentsDetails(){
    var classObj = this;
    this.userData.callApi(

      {},
      VariableConstants.METHOD_GET,
      RequestMapper.API_COURSE_ENROLLMENT,
      VariableConstants.ACCESS_PRIVATE
    ).subscribe((res: any)=>{
      // console.log(res);
      this.allStudentsInfo = res;
      var uniquelist:any = [];
      this.allStudentsInfo!.data.forEach(function (data:any) {
        if (!uniquelist[data.user_fullname]) {
          uniquelist[data.user_fullname]=1;
          classObj.allStudentsInfo_uniq.push(data);
        }

      });
    });
  }
  all_event:any=[];
  toDisplay: boolean = false;
  onSelectStudent(value:any){
    this.toDisplay = !this.toDisplay;
    this.all_event = value;
   // let data = {user_id:this.all_event}
console.log(this.all_event)

    this.userData
    .callApi(
      {},
      VariableConstants.METHOD_GET,
      RequestMapper.API_COURSE_ENROLLMENT+"?user_id="+this.all_event,
      VariableConstants.ACCESS_PRIVATE
    )
    .subscribe((result: CourseListApiData) => {
      this.courseList = result.data;

      console.log(this.courseList);
    });

  }





  }
