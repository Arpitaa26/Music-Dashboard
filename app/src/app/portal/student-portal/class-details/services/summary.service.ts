import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { IScheduleResponse } from 'src/app/portal/teacher-portal/class-details/summary/Interface/studentListInterface';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import { ICourseTypeResponse, IScheduleItemsResponse } from '../summary/summary-interface';

@Injectable({
  providedIn: 'root',
})
export class ClassDetailsService {
  constructor(private userData: UserDataService) {}

  getAllCourse():Observable<ICourseTypeResponse> {
    return this.userData.callApi(
      {},
      VariableConstants.METHOD_GET,
      RequestMapper.API_COURSE_LEVEL,
      VariableConstants.ACCESS_PRIVATE
    );
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
}
