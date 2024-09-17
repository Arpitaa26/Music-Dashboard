import { Component, OnInit } from '@angular/core';
import { UserDataService } from './services/user-data.service';
import { NgForm } from '@angular/forms';
import { Router } from '@angular/router';
import { AuthGuard } from './guard/auth.guard';
import { VariableConstants } from './variable-contants';
import { RequestMapper } from './request-mapper';
import { AuthService } from './services/auth.service';
import { CommomServiceService } from './services/commom-service.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss'],
})
export class AppComponent implements OnInit {
  title = 'svp';
  nav_status_data = false;
  nav_status(data: any) {
    this.nav_status_data = data;
    // console.log(this.nav_status_data)
  }
  constructor(
    private _auth: AuthGuard,
    private userData: UserDataService,
    private _authService: AuthService,
    private router: Router,
    private _commonService: CommomServiceService
  ) {}
  public LoggedInType(): void {
    if (this._authService.isLoggedIn()) {
      // let type = '';
      
    } else {
      // this.router.navigate([RequestMapper.LOGOUT]);
    }
  }

  ngOnInit(): void {
    this.LoggedInType();
    window.scrollTo(0, 0);
  }
}
