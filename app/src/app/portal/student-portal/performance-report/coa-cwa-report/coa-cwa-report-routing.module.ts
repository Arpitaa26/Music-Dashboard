import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { CoaCwaReportComponent } from './coa-cwa-report/coa-cwa-report.component';

const routes: Routes = [
  {
    path: '',
    component: CoaCwaReportComponent,
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class CoaCwaReportRoutingModule {}
