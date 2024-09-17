import { Injectable } from '@angular/core';
import { UserDataService } from './user-data.service';
import { VariableConstants } from '../variable-contants';
import { RequestMapper } from '../request-mapper';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  constructor() {}

  isLoggedIn() {
    return localStorage.getItem('token') !== null;
  }

  isAuthorised(token: string) {
    return localStorage.getItem('user_type') == token;
  }
}
