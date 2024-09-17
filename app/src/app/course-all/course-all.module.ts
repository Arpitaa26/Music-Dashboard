import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { CourseAllRoutingModule } from './course-all-routing.module';
import { CourseAllComponent } from './course-all/course-all.component';

@NgModule({
  declarations: [CourseAllComponent],
  imports: [CommonModule, CourseAllRoutingModule],
})
export class CourseAllModule {}
