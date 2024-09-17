import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { login } from '../login/login/login.component';
import { Router } from '@angular/router';
import { RequestMapper } from '../request-mapper';
import { VariableConstants } from '../variable-contants';
// import { signUp } from '../signup/signup/signup.component';
import { course } from '../portal/student-portal/assignments/homework-teachers-note/interface/homework-teachers-note';
import { user_pronoun } from '../signup/user_pronoun_get_all';
import { user_type } from '../basic-module/reschedule/interface/user_type';
import { ScheduleClassInterface } from '../portal/student-portal/class-details/scheduleclass/interface/scheduleclass-interface';
import { Observable, Subject } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class UserDataService {
  shearingData= new Subject;
  //   getPostData: any;

  // link = 'http://svp.payrollease.in/api/course/get_all';
  // login = 'https://svp.payrollease.in/api/user/login';

  constructor(private http: HttpClient, private router: Router) {}

  users() {
    let headers = new HttpHeaders({
      'Content-Type': 'application/json',
    }).set('api-key', `${localStorage.getItem('token')}`);

    return this.http.get<course[]>(
      'https://svp.payrollease.in/api/course/get_all',
      { headers }
    );
  }
  // downloadFile(url: string): Observable<Blob> {
  //   return this.http.get(url, { responseType: 'blob' });
  // }
  public callApi(
    data: object,
    method: string,
    url: string,
    type: string
  ): Observable<any> {
    var response;

    let headers = new HttpHeaders({
      'Content-Type': 'application/json',
      
    },);

    if (type == VariableConstants.ACCESS_PRIVATE) {
      headers = new HttpHeaders({
        'Content-Type': 'application/json',
      }).set('api-key', `${localStorage.getItem('token')}`);
    }

    let queryParams = new HttpParams();

    Object.entries(data).forEach(([key, value]) => {
      queryParams = queryParams.append(key, value);
    });

    if (method == VariableConstants.METHOD_GET) {
      response = this.http.get(RequestMapper.BASE_API_URL + url, {
        headers,
        params: queryParams,
      });
    } else if (method == VariableConstants.METHOD_POST) {
      response = this.http.post(RequestMapper.BASE_API_URL + url, data, {
        headers,
       
        observe: 'response',
        
      });
    } else if (method == VariableConstants.METHOD_FILE_POST) {
      headers = new HttpHeaders({
      }).set('api-key', `${localStorage.getItem('token')}`);

      response = this.http.post(RequestMapper.BASE_API_URL + url, data, {
        // 'Content-Type' : 'image/jpeg', 
        headers,
        observe: 'response',
      });
    } else if (method == VariableConstants.METHOD_PUT) {
      response = this.http.put(RequestMapper.BASE_API_URL + url, data, {
        headers,
        observe: 'response',
      });
    } else {
      response = this.http.delete(RequestMapper.BASE_API_URL + url, {
        headers,
      });
    }

    return response;
  }
}
