import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import { IScheduleResponse } from '../Interface/studentListInterface';

@Injectable({
  providedIn: 'root',
})
export class SummaryService {
  constructor(private userData: UserDataService) {}

  getAllCourse():Observable<IScheduleResponse> {
    return this.userData.callApi(
      {},
      VariableConstants.METHOD_GET,
      RequestMapper.API_TEACHER_COURSE_ENROLLMENT,
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

  getAllSchedule(batch_id:string){
    return this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_CLASS_SCHEDULE_GET_ALL + '?batch_id=' + batch_id,
        VariableConstants.ACCESS_PRIVATE
      )
      
  }
}
