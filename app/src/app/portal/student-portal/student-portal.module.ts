import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { StudentPortalRoutingModule } from './student-portal-routing.module';
import { StudentPortalComponent } from './student-portal/student-portal.component';
import { SidebarModule } from 'src/app/sidebar/sidebar.module';
import { NavModule } from 'src/app/nav/nav.module';
import { ClassDetailsModule } from './class-details/class-details.module';
import { dashboardComponent } from './dashboard/dashboard/dashboard.component';
import { DashboardModule } from './dashboard/dashboard.module';
import { AllCoursesComponent } from './all-courses/all-courses/all-courses.component';


@NgModule({
  declarations: [StudentPortalComponent],
  imports: [
    CommonModule,
    StudentPortalRoutingModule,
    SidebarModule,
    NavModule,
    ClassDetailsModule,
    
  ],

  exports: [StudentPortalComponent],
})
export class StudentPortalModule {}
