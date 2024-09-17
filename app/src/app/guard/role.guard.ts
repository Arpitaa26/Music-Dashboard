import { CanActivateFn } from '@angular/router';

import { Injectable } from '@angular/core';
import {
  ActivatedRouteSnapshot,
  Router,
  RouterStateSnapshot,
} from '@angular/router';
import { Observable } from 'rxjs';
import { AuthService } from '../services/auth.service';
import { RequestMapper } from '../request-mapper';
import { CommomServiceService } from '../services/commom-service.service';

@Injectable({
  providedIn: 'root',
})
export class roleGuard {
  constructor(
    private auth: AuthService,
    private router: Router,
    private _commonService: CommomServiceService
  ) {}
  canActivate(
    route: ActivatedRouteSnapshot,
    state: RouterStateSnapshot
  ): boolean {
    const role = route.data['role'];

    console.log(role);
    let isAuth = this.auth.isAuthorised(role);

    if (isAuth) {
      return true;
    } else {
      this.router.navigate(['/logout']);
      return false;
    }
  }
}
