import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { CourseInfoRoutingModule } from './course-info-routing.module';
import { CourseInfoComponent } from './course-info/course-info.component';



@NgModule({
  declarations: [
    CourseInfoComponent
  ],
  imports: [
    CommonModule,
    CourseInfoRoutingModule
  ]
})
export class CourseInfoModule { }
