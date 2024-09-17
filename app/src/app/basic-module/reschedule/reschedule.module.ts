import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { RescheduleRoutingModule } from './reschedule-routing.module';
import { RescheduleComponent } from './reschedule/reschedule.component';


@NgModule({
  declarations: [
    RescheduleComponent
  ],
  imports: [
    CommonModule,
    RescheduleRoutingModule
  ],
  exports:[
    RescheduleComponent
  ]
})
export class RescheduleModule { }
