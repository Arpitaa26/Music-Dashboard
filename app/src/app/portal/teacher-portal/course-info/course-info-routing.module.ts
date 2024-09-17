import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { RequestMapper } from 'src/app/request-mapper';
import { CourseInfoComponent } from './course-info/course-info.component';

const routes: Routes = [
  {
    path: '',
    component: CourseInfoComponent,
   
  },
  {
    path: 'course-user/:course_id',
    loadChildren: () =>
      import('../../teacher-portal/course-info/course-user/course-user.module').then(
        (m) => m.CourseUserModule
      ),
  },
  {
    path: RequestMapper.MODULE_LIST + '/:userId/:batchId/:id',
    loadChildren: () =>
      import('./module-list/module-list.module').then(
        (m) => m.ModuleListModule
      ),
  },

];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class CourseInfoRoutingModule {}
