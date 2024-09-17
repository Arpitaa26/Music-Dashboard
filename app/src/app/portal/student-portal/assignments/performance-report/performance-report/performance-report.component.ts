import { Component, OnInit } from '@angular/core';
import { PerformanceReport } from '../model/performance-report';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import { RequestMapper } from 'src/app/request-mapper';
import { CourseLevelInterface } from '../interface/courseLevelInterface';
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
@Component({
  selector: 'app-performance-report',
  templateUrl: './performance-report.component.html',
  styleUrls: ['./performance-report.component.scss'],
})
export class PerformanceReportComponent implements OnInit {
  performanceMenu = PerformanceReport.menuMethod;
  courseLevel: null | undefined | CourseLevelInterface;
  courseName: any;
  selectedIndex: number = 0;
  selectedIndex_table:number=0;
  loading: boolean = true;

  constructor(private userData: UserDataService) {}

  ngOnInit(): void { 
    this.userData.callApi(
          {},
          VariableConstants.METHOD_GET,
          RequestMapper.API_COURSE_LEVEL,
          VariableConstants.ACCESS_PRIVATE
        ).subscribe((result: any) => {
        this.courseLevel = result;
        console.log(this.courseLevel)
        let att_id:any = this.courseLevel?.data[0].id;
        this.getModuleByLevel(att_id, 0);
      });

    // this.getModuleByLevel('1', 0);
   
  }
  getModuleByLevel(id: string, index: number) {

    this.selectedIndex = index;

    this.userData.callApi(
        { course_level_id: id },
        VariableConstants.METHOD_GET,
        RequestMapper.API_TEACHER_COURSE_ENROLLMENT,
        VariableConstants.ACCESS_PRIVATE
      ).subscribe((result: any) => {
       
        this.courseName = result.data;
        
        console.log(this.courseName);
        this.loading = false;
      });
  }
  report:any=[]
show_table:boolean=false
show_active:boolean =  false;
selectedType: string = '';
  coacwa(data:any){
    // this.selectedIndex_table = index;
    console.log(data.course_id)
    let course_id = data.course_id;
    let course_level_id = data.course_level_id;
    this.userData.callApi(
      {},
      VariableConstants.METHOD_GET,
      RequestMapper.API_COA_CWA_GET_ALL+"?course_id="+course_id+"&course_level_id="+course_level_id,
      VariableConstants.ACCESS_PRIVATE
    ).subscribe((result: any) => {
      this.show_table=true;
      this.report = result;
      console.log(this.report.code)
      this.status = this.report.code
    //  this.show_active = 'active';    
    this.show_active = !this.show_active;   
    });
  }
 status:any;
  download_url(slug:any){
    var x = localStorage.getItem("token");
  console.log(slug)

  console.log(x)
    this.userData.callApi(
      {},
      VariableConstants.METHOD_GET,
      RequestMapper.API_FILE_DOWNLOAD+"/"+slug + "?api-key=" + x,
      VariableConstants.ACCESS_PRIVATE
    ).subscribe((result: any) => {
       console.log(result);
    
    });



    //const content = 'This is the content of the file you want to download.';
    //const fileUrl = "https://svp.payrollease.in/api/file/download/"+slug; // Replace with the actual URL of the file you want to download

    // this.userData.downloadFile(fileUrl).subscribe(blob => {
    //   const link = document.createElement('a');
    //   link.href = window.URL.createObjectURL(blob);
    //   link.download = 'downloaded_file';
    //   link.click();
    // });


















  }
  activeTab: number|null=null; // Set the initial active tab

  selectTab(tabNumber: number) {
    this.activeTab = tabNumber;
  }
}
