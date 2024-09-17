import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { LoginRoutingModule } from './login-routing.module';
import { LoginComponent } from './login/login.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { SignupModule } from '../signup/signup.module';
import { RouterModule } from '@angular/router';
import { CourseAllModule } from '../course-all/course-all.module';
import { ComponentModule } from '../component/component.module';

@NgModule({
  declarations: [LoginComponent],
  imports: [
    CommonModule,
    LoginRoutingModule,
    FormsModule,
    ReactiveFormsModule,
    HttpClientModule,
    SignupModule,
    CourseAllModule,ComponentModule
  ],
})
export class LoginModule {}
