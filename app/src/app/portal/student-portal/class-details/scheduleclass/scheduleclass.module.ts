import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ScheduleclassRoutingModule } from './scheduleclass-routing.module';
import { ScheduleclassComponent } from './scheduleclass/scheduleclass.component';
import { RescheduleModule } from 'src/app/basic-module/reschedule/reschedule.module';
import { HttpClientModule } from '@angular/common/http';

@NgModule({
  declarations: [
    ScheduleclassComponent
  ],
  imports: [
    CommonModule,
    ScheduleclassRoutingModule,
    RescheduleModule,HttpClientModule,FormsModule
  ]
})
export class ScheduleclassModule {

  
 }
