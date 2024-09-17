import { Component, OnInit } from '@angular/core';

import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import { RequestMapper } from 'src/app/request-mapper';
import { Router } from '@angular/router';
import { Location } from '@angular/common';
import { CommomServiceService } from 'src/app/services/commom-service.service';

@Component({
  selector: 'app-assignment',
  templateUrl: './assignment.component.html',
  styleUrls: ['./assignment.component.scss'],
})
export class AssignmentComponent implements OnInit {
  allStudentsInfo: any = [];
  studentId: any = '';
  constructor(
    private userData: UserDataService,
    private router: Router,
    private location: Location,
    private commonService: CommomServiceService
  ) {}

  ngOnInit(): void {
    this.getStudentsDetails();
  }
  allStudentsInfo_uniq: any = [];
  getStudentsDetails() {
    var classObj = this;

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
  // sortedItems(): any[] {
  //   return this.allStudentsInfo.sort();
  // }
  sortedItems(): { user_fullname: any,course_name:any,id:any }[] {
    return this.allStudentsInfo.slice().sort((a: { user_fullname: string,course_name:string }, b: { user_fullname: any,course_name:any }) => a.user_fullname.localeCompare(b.user_fullname));
  }
  all_event: any = [];
  toDisplay: boolean = false;
  onSelectStudent(value: any) {
    this.toDisplay = true;
    // this.location.back();
    // this.router.navigate(['../performa_report']);
    // window.location.reload();
    this.all_event = '';
    this.all_event = value;
    const { batch_id, user_id } = this.allStudentsInfo.find(
      (el: any) => el.id === this.all_event
    );
    this.commonService.assignmentStudentId.next({ batch_id, user_id });
  }
}
