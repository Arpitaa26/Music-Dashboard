import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ModuleListComponent } from './module-list/module-list.component';
import { RequestMapper } from 'src/app/request-mapper';

const routes: Routes = [
  {
    path: '',
    component: ModuleListComponent,
  },
  {
    path: RequestMapper.COURSE_SHOW + '/:levelId/:moduleId',
    loadChildren: () =>
      import('../course-showcase/course-showcase.module').then(
        (m) => m.CourseShowcaseModule
      ),
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ModuleListRoutingModule {}
