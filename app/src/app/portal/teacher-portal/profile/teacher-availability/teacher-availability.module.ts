import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { TeacherAvailabilityRoutingModule } from './teacher-availability-routing.module';
import { TeacherAvailabilityComponent } from './teacher-availability/teacher-availability.component';
import { ReactiveFormsModule } from '@angular/forms';


@NgModule({
  declarations: [
    TeacherAvailabilityComponent
  ],
  imports: [
    CommonModule,
    TeacherAvailabilityRoutingModule,
    ReactiveFormsModule
  ]
})
export class TeacherAvailabilityModule { }
