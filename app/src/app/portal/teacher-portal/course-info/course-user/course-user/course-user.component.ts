import { Component } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';

@Component({
  selector: 'app-course-user',
  templateUrl: './course-user.component.html',
  styleUrls: ['./course-user.component.scss']
})
export class CourseUserComponent {
  constructor(private route: Router, private userData: UserDataService,private aRoute:ActivatedRoute) {
  }
  courseListAll_uniq:any = [];
  userList:any;
  ngOnInit(): void {

    let courseId =this.aRoute.snapshot.paramMap.get('course_id');

    // this.base_url = 'https://thesvpacademy.com/admin/file/open/';
    var classObj = this;

    this.userData
    .callApi(
      {},
      VariableConstants.METHOD_GET,
      RequestMapper.API_COURSE_ENROLMENT_GET_ALL+"?course_id="+courseId,
      VariableConstants.ACCESS_PRIVATE
    )
    .subscribe((result: any) => {
      this.userList = result;
    //  location.reload();
      console.log(this.userList.data);

      var uniquelist:any = [];
      this.userList.data!.forEach(function (data:any) {
        if (!uniquelist[data.user_id]) {
          uniquelist[data.user_id]=1;
          classObj.courseListAll_uniq.push(data);
        } 
      });
      console.log(this.courseListAll_uniq);
    });
    
  }
  onSelectStudent(data:any){}
}
