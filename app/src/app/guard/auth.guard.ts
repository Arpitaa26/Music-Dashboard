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
export class AuthGuard {
  constructor(
    private auth: AuthService,
    private router: Router,
    private _commonService: CommomServiceService
  ) {}
  canActivate(
    route: ActivatedRouteSnapshot,
    state: RouterStateSnapshot
  ): boolean {
    if (this.auth.isLoggedIn()) {
      return true;
    } else {
      this.router.navigate(['/logout']);
      return false;
    }
  }
}
