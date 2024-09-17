import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { CourseListApiObj } from 'src/app/ConstantInterface/courseListApiInterface';
import {
  ModuleListGetApi,
  ModuleListGetdata,
} from 'src/app/ConstantInterface/moduleListGet';
import {
  ModuleListLevelApi,
  ModuleListLevelApiObj,
} from 'src/app/ConstantInterface/moduleListLevel';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';

@Component({
  selector: 'app-module-list',
  templateUrl: './module-list.component.html',
  styleUrls: ['./module-list.component.scss'],
})
export class ModuleListComponent implements OnInit {
  course_name: string = '';
  course_desc: string = '';
  courseList: ModuleListGetdata|undefined|any = {} as ModuleListGetdata;
  courseLevel: any;
  selectedIndex: number = 0;
  courseId:any = this.aRoute.snapshot.paramMap.get('id');;
  constructor(private route: Router, private userData: UserDataService,private aRoute:ActivatedRoute) {}
  ngOnInit(): void {
    // this.course_name = localStorage.getItem('course_name')!;
    // this.course_desc = localStorage.getItem('course_long_desc')!;
    
    
    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.COURSE_LEVEL,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: ModuleListLevelApi) => {
        this.courseLevel = result.data;
        console.log(this.courseLevel);
        this.getModuleByLevel(this.courseLevel[0].id, 0);
      });
   

  }
response_lavel:any
  getModuleByLevel(level_Id: number, index: number) {
    this.selectedIndex = index;
    // var element = event.target || event.srcElement || event.currentTarget;

    let levelId = level_Id;
    // console.log(event);

    this.userData
      .callApi(
        { course_id: this.courseId, course_level_id: levelId },
        VariableConstants.METHOD_GET,
        RequestMapper.API_MODULE_GET,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: ModuleListGetApi) => {
        this.courseList = [];
        this.response_lavel = result.code;
        if(result.code==200){
       
  
          this.courseList = result;
          // $scope.repartizations = this.courseList
          this.course_name = result.data[0].course_name;
          this.course_desc = result.data[0].description;
          // console.log(resData);
          
        }else if(result.code==203){
          // alert(result.message);
        }else{
          // alert(result.message);
        }
        
      });
  }
}
