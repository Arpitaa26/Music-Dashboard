import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { TeacherAvailabilityComponent } from './teacher-availability/teacher-availability.component';

const routes: Routes = [
  {
    path:'',
    component: TeacherAvailabilityComponent
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class TeacherAvailabilityRoutingModule { }
