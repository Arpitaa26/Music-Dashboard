import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { RequestMapper } from 'src/app/request-mapper';
import { AllCoursesComponent } from './all-courses/all-courses.component';

const routes: Routes = [
  {
    path: '',
    component: AllCoursesComponent,
  },

  {
    path:  ':cId/:lavel/:type',
    loadChildren: () =>
      import('./course-buy/course-buy.module').then(
        (m) =>m.CourseBuyModule
      ),
  },

];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class AllCoursesRoutingModule { }
