import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { CoaCwaReportRoutingModule } from './coa-cwa-report-routing.module';
import { CoaCwaReportComponent } from './coa-cwa-report/coa-cwa-report.component';

@NgModule({
  declarations: [CoaCwaReportComponent],
  imports: [CommonModule, CoaCwaReportRoutingModule],
  // exports: [CoaCwaReportComponent],
})
export class CoaCwaReportModule {}
