import { Injectable } from '@angular/core';
import { UserDataService } from './user-data.service';
import { VariableConstants } from '../variable-contants';
import { RequestMapper } from '../request-mapper';
import { BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class CommomServiceService {
  assignmentStudentId = new BehaviorSubject<any>(null);

  constructor(private userData: UserDataService) {}
  storedUserType = '';
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
}
