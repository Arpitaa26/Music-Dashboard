import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { TwoCourseComponentRoutingModule } from './two-course-component-routing.module';
import { TwoCourseComponentComponent } from './two-course-component/two-course-component.component';
import { BrowserModule } from '@angular/platform-browser';
import { RouterModule } from '@angular/router';
import { CourseInfoComponent } from '../../teacher-portal/course-info/course-info/course-info.component';
import { AllCoursesComponent } from '../all-courses/all-courses/all-courses.component';


@NgModule({
  declarations: [
    TwoCourseComponentComponent,
  ],
  imports: [
    CommonModule,
    TwoCourseComponentRoutingModule,
  ],
})
export class TwoCourseComponentModule { }
