import { Component, NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { TeacherAvailabilityRoutingModule } from './teacher-availability-routing.module';
import { TeacherAvailabilityComponent } from './teacher-availability/teacher-availability.component';
import { ReactiveFormsModule } from '@angular/forms';
import { ComponentModule } from 'src/app/component/component.module';


@NgModule({
  declarations: [
    TeacherAvailabilityComponent
  ],
  imports: [
    CommonModule,
    TeacherAvailabilityRoutingModule,
    ReactiveFormsModule,ComponentModule
  ]
})
export class TeacherAvailabilityModule { }
