import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { CalenderviewRoutingModule } from './calenderview-routing.module';
import { CalendarStatusStudentPipe, CalenderviewComponent } from './calenderview/calenderview.component';
import { CalendarModule, DateAdapter } from 'angular-calendar';
import { adapterFactory } from 'angular-calendar/date-adapters/date-fns';
import { FlatpickrModule } from 'angularx-flatpickr';

@NgModule({
  declarations: [CalenderviewComponent, CalendarStatusStudentPipe],
  imports: [
    CommonModule,
    CalenderviewRoutingModule,
    FlatpickrModule.forRoot(),
    CalendarModule.forRoot({
      provide: DateAdapter,
      useFactory: adapterFactory,
    }),
  ],
})
export class CalenderviewModule {}
