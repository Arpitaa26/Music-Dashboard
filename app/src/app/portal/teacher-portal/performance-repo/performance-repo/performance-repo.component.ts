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
  courseId: any;
  initialId: any;
  constructor(
    private userData: UserDataService,
    private commonService: CommomServiceService
  ) {}
  performanceMenu = PerformanceReport.menuMethod;
  courseLevel: null | undefined | CourseLevelInterface;
  courseName: any[] = [];
  selectedIndex!: string;
  studentId: any = '';
  loadingCoaCwa: boolean = false;
  ngOnInit(): void {
    this.getStudentsDetails();
    this.courses_lavel_gets();
  }

  courses_lavel_gets() {
    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_COURSE_LEVEL,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.courseLevel = result;
        this.courseName = [];
        this.initialId = this.courseLevel?.data[0].id;
      });
  }
  allStudentsInfo_uniq: any = [];
  allStudentsInfo: any = [];
  getStudentsDetails() {
    // var classObj = this;

    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_COURSE_ENROLLMENT,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((res) => {
        this.allStudentsInfo = res.data;
        var uniquelist: any = [];
        // this.allStudentsInfo!.data.forEach(function (data: any) {
        //   if (!uniquelist[data.user_fullname]) {
        //     uniquelist[data.user_fullname] = 1;
        //     classObj.allStudentsInfo_uniq.push(data);
        //   }
        // });
      });
  }
  sortedItems(): { user_fullname: any; course_name: any; id: any }[] {
    return this.allStudentsInfo
      .slice()
      .sort(
        (
          a: { user_fullname: string; course_name: string },
          b: { user_fullname: any; course_name: any }
        ) => a.user_fullname.localeCompare(b.user_fullname)
      );
  }
  onSelectStudent(value: any) {
    this.show_table = false;
    const { user_id, course_id } = this.allStudentsInfo.find(
      (el: any) => el.id === value
    );
    this.userId = user_id;
    this.courseId = course_id;
    // this.courses_lavel_gets();
    //this.getModuleByLevel(menu.id)
    this.getModuleByLevel(this.initialId);
    this.coacwa(this.initialId)
    // this.coacwa()
  }

  getModuleByLevel(course_level_id: string) {
    this.loading = true;
    this.selectedIndex = course_level_id.toString();
    this.userData
      .callApi(
        { course_level_id, user_id: this.userId, course_id: this.courseId },
        VariableConstants.METHOD_GET,
        RequestMapper.API_TEACHER_COURSE_ENROLLMENT,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.courseName = result.data || [];

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
    this.loadingCoaCwa = true;
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
          course_level_id +
          '&student_id=' +
          this.userId,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.report = result;
        console.log(this.report.code);
        this.status = this.report.code;
        //  this.show_active = 'active';
        this.show_active = !this.show_active;
        this.show_table = true;
        this.loadingCoaCwa = false;
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
