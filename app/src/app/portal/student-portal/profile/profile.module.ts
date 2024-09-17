import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ProfileRoutingModule } from './profile-routing.module';
import { StudentProfileComponent } from './student-profile/student-profile.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';


@NgModule({
  declarations: [
    StudentProfileComponent
  ],
  imports: [
    CommonModule,
    ProfileRoutingModule,
    FormsModule,ReactiveFormsModule
  ]
})
export class ProfileModule { }
