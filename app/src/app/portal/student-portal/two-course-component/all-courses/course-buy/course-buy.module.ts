import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { CourseBuyRoutingModule } from './course-buy-routing.module';
import { CourseBuysComponent } from './course-buy/course-buy.component';
import { FormsModule } from '@angular/forms';
import {  CamelCaseToTitleCaseTwoPipe } from 'src/app/camelCaseToTitleCase/camel-case-to-title-case.pipe';
import { ComponentModule } from 'src/app/component/component.module';

@NgModule({
  declarations: [CourseBuysComponent,CamelCaseToTitleCaseTwoPipe],
  imports: [CommonModule, CourseBuyRoutingModule, FormsModule,ComponentModule],
})
export class CourseBuyModule {}
// CamelCaseToTitleCasePipe