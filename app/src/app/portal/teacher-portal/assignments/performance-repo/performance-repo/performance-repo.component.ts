import { Component, Input, OnInit } from '@angular/core';

import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import { RequestMapper } from 'src/app/request-mapper';
import { PerformanceReport } from 'src/app/portal/student-portal/assignments/performance-report/model/performance-report';
import { CourseLevelInterface } from 'src/app/portal/student-portal/assignments/performance-report/interface/courseLevelInterface';
import { CommomServiceService } from 'src/app/services/commom-service.service';
@Component({
  selector: 'app-performance-repo',
  templateUrl: './performance-repo.component.html',
  styleUrls: ['./performance-repo.component.scss'],
})
export class PerformanceRepoComponent implements OnInit {
  @Input('studentId') public data: any = [];
  userId: any;
  initialId: any;
  constructor(
    private userData: UserDataService,
    private commonService: CommomServiceService
  ) {
    // this.commonService.assignmentStudentId.subscribe((data:any) => {
    //   this.userId  = data;
    //   // this.getModuleByLevel('0', 0);

    // });

    this.commonService.assignmentStudentId.subscribe((id: number) => {
      this.userData
        .callApi(
          {},
          VariableConstants.METHOD_GET,
          RequestMapper.API_COURSE_LEVEL,
          VariableConstants.ACCESS_PRIVATE
        )
        .subscribe((result: any) => {
          this.courseLevel = result;
          this.initialId = this.courseLevel?.data[0].id;
          this.courseName = [];
          this.userId = id.toString();
          this.getModuleByLevel(this.initialId, this.userId);
        });
    });
  }
  performanceMenu = PerformanceReport.menuMethod;
  courseLevel: null | undefined | CourseLevelInterface;
  courseName: any;
  selectedIndex!: string;

  ngOnInit(): void {
  
  }

  getModuleByLevel(id: string, index: number) {
    this.selectedIndex = id.toString();
    this.userData
      .callApi(
        { course_level_id: id, user_id: this.userId },
        VariableConstants.METHOD_GET,
        RequestMapper.API_TEACHER_COURSE_ENROLLMENT,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.courseName = result.data;
        console.log(this.courseName);
        this.loading = false;
      });
  }

  loading: boolean = true;
  status: any;
  report: any = [];
  show_table: boolean = false;
  show_active: boolean = false;
  selectedType: string = '';
  coacwa(data: any) {
 
    console.log(data.course_id);
    let course_id = data.course_id;
    let course_level_id = data.course_level_id;
    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_COA_CWA_GET_ALL +
          '?course_id=' +
          course_id +
          '&course_level_id=' +
          course_level_id,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.show_table = true;
        this.report = result;
        console.log(this.report.code);
        this.status = this.report.code;
        //  this.show_active = 'active';
        this.show_active = !this.show_active;
      });
  }

  download_url(slug: any) {
    var x = localStorage.getItem('token');
    console.log(slug);

    console.log(x);
    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_FILE_DOWNLOAD + '/' + slug + '?api-key=' + x,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
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
  activeTab: number | null = null; // Set the initial active tab

  selectTab(tabNumber: number) {
    this.activeTab = tabNumber;
  }
}
