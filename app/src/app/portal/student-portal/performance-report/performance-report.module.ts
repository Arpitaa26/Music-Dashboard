import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { PerformanceReportRoutingModule } from './performance-report-routing.module';
import { PerformanceReportComponent } from './performance-report/performance-report.component';
import { PerformanceCommonComponent } from './performance-common/performance-common.component';

import { CoaCwaReportModule } from './coa-cwa-report/coa-cwa-report.module';



@NgModule({
  declarations: [
    PerformanceReportComponent,
    PerformanceCommonComponent
  ],
  imports: [
    CommonModule,
    PerformanceReportRoutingModule,
    
  ],
})
export class PerformanceReportModule { }
