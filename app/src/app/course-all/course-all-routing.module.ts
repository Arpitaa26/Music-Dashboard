import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { CourseAllComponent } from './course-all/course-all.component';
import { RequestMapper } from '../request-mapper';

const routes: Routes = [
  {
    path: '',
    component: CourseAllComponent,
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class CourseAllRoutingModule {}
