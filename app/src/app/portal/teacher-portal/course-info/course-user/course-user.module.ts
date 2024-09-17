import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { CourseUserRoutingModule } from './course-user-routing.module';
import { CourseUserComponent } from './course-user/course-user.component';
import { ReactiveFormsModule } from '@angular/forms';


@NgModule({
  declarations: [
    CourseUserComponent
  ],
  imports: [
    CommonModule,
    CourseUserRoutingModule,ReactiveFormsModule
  ]
})
export class CourseUserModule { }
