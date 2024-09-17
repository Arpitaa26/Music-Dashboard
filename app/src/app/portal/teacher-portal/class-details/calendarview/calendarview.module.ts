import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { CalendarviewRoutingModule } from './calendarview-routing.module';
import { CalendarviewComponent } from './calendarview/calendarview.component';
import { CalendarModule, DateAdapter } from 'angular-calendar';
import { adapterFactory } from 'angular-calendar/date-adapters/date-fns';
import { FlatpickrModule } from 'angularx-flatpickr';
import { CalendarStatusFilterPipe } from 'src/app/pipes/calendar-status-filter.pipe';

@NgModule({
  declarations: [CalendarviewComponent,CalendarStatusFilterPipe],
  imports: [
    CommonModule,
    CalendarviewRoutingModule,
    FlatpickrModule.forRoot(),
    CalendarModule.forRoot({
      provide: DateAdapter,
      useFactory: adapterFactory,
    }),
  ],
})
export class CalendarviewModule {}
