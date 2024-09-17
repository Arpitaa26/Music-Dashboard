import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ScheduleclassRoutingModule } from './scheduleclass-routing.module';
import { ScheduleclassComponent } from './scheduleclass/scheduleclass.component';

@NgModule({
  declarations: [ScheduleclassComponent],
  imports: [CommonModule, ScheduleclassRoutingModule, FormsModule],
})
export class ScheduleclassModule {}
