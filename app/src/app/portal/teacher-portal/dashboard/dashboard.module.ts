import { NgModule } from '@angular/core';
import { CommonModule, DatePipe } from '@angular/common';
import { NgImageSliderComponent, NgImageSliderModule } from 'ng-image-slider';

import { DashboardRoutingModule } from './dashboard-routing.module';
import {
  DashboardComponent,
  GetScheduleByStatusTwoPipe,
} from './dashboard/dashboard.component';
import { FormsModule, NgForm, ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { CustomdatePipe } from 'src/app/date/customdate.pipe';
import { ComponentModule } from 'src/app/component/component.module';

@NgModule({
  declarations: [
    DashboardComponent,
    CustomdatePipe,
    GetScheduleByStatusTwoPipe,
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
