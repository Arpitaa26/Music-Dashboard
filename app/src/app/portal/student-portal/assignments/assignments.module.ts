import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { AssignmentsRoutingModule } from './assignments-routing.module';
import { AssignmentsComponent } from './assignments/assignments.component';
import { CoaCwaReportComponent } from './performance-report/coa-cwa-report/coa-cwa-report/coa-cwa-report.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

@NgModule({
  declarations: [AssignmentsComponent],
  imports: [CommonModule, AssignmentsRoutingModule,FormsModule,ReactiveFormsModule],
})
export class AssignmentsModule {}
