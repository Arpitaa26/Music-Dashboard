import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { RequestMapper } from 'src/app/request-mapper';
import { CourseUserComponent } from './course-user/course-user.component';

const routes: Routes = [
  {
    path:'',component:CourseUserComponent
  },
  {
    path: RequestMapper.MODULE_LIST + '/:userId/:batchId/:id',
    loadChildren: () =>
      import('../../../teacher-portal/course-info/module-list/module-list.module').then(
        (m) => m.ModuleListModule
      ),
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class CourseUserRoutingModule { }
