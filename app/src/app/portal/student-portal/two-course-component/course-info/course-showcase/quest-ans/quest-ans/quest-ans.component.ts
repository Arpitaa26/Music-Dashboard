import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';

@Component({
  selector: 'app-quest-ans',
  templateUrl: './quest-ans.component.html',
  styleUrls: ['./quest-ans.component.scss'],
})
export class QuestAnsComponent implements OnInit {
  courseName: string = '';
  courseDesc: string = '';
  courseDetails: any;
  course_id:any;
  constructor(private route: Router, private aroute:ActivatedRoute,private userData: UserDataService) {}
  ngOnInit(): void {
    let courseId = this.route.url.split('/').slice(2)[3];
    this.course_id=this.aroute.snapshot.params['levelId'];
    console.log("test:"+this.course_id)

    this.userData
      .callApi(
        { course_id: courseId },
        VariableConstants.METHOD_GET,
        RequestMapper.API_COURSE,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        console.log(result);
        this.courseDetails = result.data;
      });
  }
}
