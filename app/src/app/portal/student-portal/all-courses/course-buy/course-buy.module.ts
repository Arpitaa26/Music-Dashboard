import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { CourseBuyRoutingModule } from './course-buy-routing.module';
import { CourseBuyComponent } from './course-buy/course-buy.component';
import { FormsModule } from '@angular/forms';


@NgModule({
  declarations: [
    CourseBuyComponent
  ],
  imports: [
    CommonModule,
    CourseBuyRoutingModule,FormsModule
  ]
})
export class CourseBuyModule { }
