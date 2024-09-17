import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { TeacherportalRoutingModule } from './teacher-portal-routing.module';
import { TeacherportalComponent } from './teacher-portal/teacher-portal.component';
import { SidebarModule } from 'src/app/sidebar/sidebar.module';
import { NavModule } from 'src/app/nav/nav.module';
import { ReschduleApproveComponent } from './reschdule-approve/reschdule-approve/reschdule-approve.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

@NgModule({
  declarations: [TeacherportalComponent,ReschduleApproveComponent],
  imports: [CommonModule, TeacherportalRoutingModule, SidebarModule,FormsModule, NavModule],
  exports: [TeacherportalComponent],
})
export class TeacherportalModule {}
