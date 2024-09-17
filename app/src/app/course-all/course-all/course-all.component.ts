import { Component, OnInit } from '@angular/core';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import { CourseAllModule } from '../course-all.module';
import { CourseListModel } from '../model/courseListModel';

@Component({
  selector: 'app-course-all',
  templateUrl: './course-all.component.html',
  styleUrls: ['./course-all.component.scss'],
})
export class CourseAllComponent implements OnInit {
  courseList: any = CourseListModel.returnMethod;
  constructor(private userData: UserDataService) {}
  ngOnInit(): void {
    // this.userData
    //   .callApi(
    //     {},
    //     VariableConstants.METHOD_GET,
    //     RequestMapper.API_COURSE,
    //     VariableConstants.ACCESS_PRIVATE
    //   )
    //   .subscribe((result: any) => {
    //     console.log(result.data);
    //   });
  }
}
