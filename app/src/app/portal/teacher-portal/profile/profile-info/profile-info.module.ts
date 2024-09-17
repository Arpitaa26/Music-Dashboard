import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ProfileInfoRoutingModule } from './profile-info-routing.module';
import { TeacherProfileComponent } from './teacher-profile/teacher-profile.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';


@NgModule({
  declarations: [
    TeacherProfileComponent
  ],
  imports: [
    CommonModule,
    ProfileInfoRoutingModule,ReactiveFormsModule,FormsModule
  ]
})
export class ProfileInfoModule { }
