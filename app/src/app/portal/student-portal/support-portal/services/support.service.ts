import { Injectable } from '@angular/core';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';

@Injectable({
  providedIn: 'root',
})
export class SupportService {
    constructor(  private userData: UserDataService){

    }
  postCommentWithAttachment(data :any) {
   return this.userData.callApi(
      data,
      VariableConstants.METHOD_FILE_POST,
      RequestMapper.API_POST_COMMENT,
      VariableConstants.ACCESS_PRIVATE
    );
  }

  postComment(data :any) {
    return this.userData.callApi(
       data,
       VariableConstants.METHOD_POST,
       RequestMapper.API_POST_COMMENT,
       VariableConstants.ACCESS_PRIVATE
     );
   }

   getAllMessages(task_id:string){
   return this.userData
      .callApi(
        {
          task_id
        },
        VariableConstants.METHOD_GET,
        RequestMapper.API_TASK_COMMENT,
        VariableConstants.ACCESS_PRIVATE
      )
   }
}
