import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { AllCoursesRoutingModule } from './all-courses-routing.module';
import { AllCoursesComponent } from './all-courses/all-courses.component';
import { FormsModule } from '@angular/forms';
import { CamelCaseToTitleCasePipe } from 'src/app/camelCaseToTitleCase/camel-case-to-title-case.pipe';


@NgModule({
  declarations: [
    AllCoursesComponent,
  ],
  imports: [
    CommonModule,
    AllCoursesRoutingModule,FormsModule
  ]
})
export class AllCoursesModule { }
