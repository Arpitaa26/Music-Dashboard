import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { PortalRoutingModule } from './portal-routing.module';
import { PortalComponent } from './portal/portal.component';
import { StudentPortalModule } from './student-portal/student-portal.module';
import { TeacherportalModule } from './teacher-portal/teacher-portal.module';
import { FormsModule } from '@angular/forms';

@NgModule({
  declarations: [
    PortalComponent,
    // StudentportalComponent,
    
  ],
  imports: [
    CommonModule,
    PortalRoutingModule,
    // StudentPortalModule,
    // TeacherportalModule,
    FormsModule
  ],
})
export class PortalModule {}
