import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable } from 'rxjs';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import { ICourseTypeResponse, IScheduleItemsResponse } from '../interface/assignments';

@Injectable({
  providedIn: 'root',
})
export class AssignmentService {
  assignmentCourseId = new BehaviorSubject<{ course_id : any | string, batch_id:string}>({ course_id :  '', batch_id:''});
  assignmentIds = this.assignmentCourseId.asObservable()

  constructor(private userData: UserDataService) {}
 
  getAllCourse():Observable<ICourseTypeResponse> {
    return this.userData.callApi(
      {},
      VariableConstants.METHOD_GET,
      RequestMapper.API_COURSE_LEVEL,
      VariableConstants.ACCESS_PRIVATE
    )
  }

  getCourseById(user_id: string) {
   return this.userData.callApi(
      {},
      VariableConstants.METHOD_GET,
      RequestMapper.API_TEACHER_COURSE_ENROLLMENT + '?user_id=' + user_id,
      VariableConstants.ACCESS_PRIVATE
    );
  }

  getAllSchedule(batch_id:string, course_level_id:string):Observable<IScheduleItemsResponse>{
    return this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_CLASS_SCHEDULE_GET_ALL + '?batch_id=' + batch_id +
        '&course_level_id=' +
        course_level_id,
        VariableConstants.ACCESS_PRIVATE
      )
  }

  // LoggedInType() {
  //   let type = '';
  //   this.userData
  //     .callApi(
  //       {},
  //       VariableConstants.METHOD_GET,
  //       RequestMapper.API_USER_TYPE,
  //       VariableConstants.ACCESS_PRIVATE
  //     )
  //     .subscribe((result: any) => {
  //       let data = result.data;
  //       type = data.type;
  //       console.log(type.toLowerCase());
  //     });

  //   return type.toLowerCase();
  // }

  setAssignMentId( data : {course_id : any | string, batch_id:string}){
    this.assignmentCourseId.next(data)
  }
}
