import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class LoginService {

  constructor(private http:HttpClient) { }

  loginUser(data:any){

    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
    });

    const requestOptions = { headers: headers };

    return this.http.post(
      'https://svp.payrollease.in/api/user/login',
      data,
      requestOptions
    );
  }
}
