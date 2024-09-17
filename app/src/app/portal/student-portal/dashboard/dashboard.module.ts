import { NgModule } from '@angular/core';
import { CommonModule, DatePipe } from '@angular/common';
import { NgImageSliderModule } from 'ng-image-slider';

import { DashboardRoutingModule } from './dashboard-routing.module';
import {
  dashboardComponent, GetScheduleByStatusPipe,
} from './dashboard/dashboard.component';
import { HttpClientModule } from '@angular/common/http';
import { FormsModule } from '@angular/forms';
import { BarGroupComponent } from './bar-group/bar-group.component';
import { ComponentModule } from 'src/app/component/component.module';
import {
  CustomdatedatePipe,
  CustomdatePipe,
} from 'src/app/date/customdate.pipe';

@NgModule({
  declarations: [
    dashboardComponent,
    BarGroupComponent,
    CustomdatedatePipe,
    GetScheduleByStatusPipe,
  ],
  imports: [
    CommonModule,
    DashboardRoutingModule,
    HttpClientModule,
    NgImageSliderModule,
    FormsModule,
    ComponentModule,
  ],
  providers: [DatePipe],
})
export class DashboardModule {}
