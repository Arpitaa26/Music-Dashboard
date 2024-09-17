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
    path: RequestMapper.MODULE_LIST + '/:id',
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
