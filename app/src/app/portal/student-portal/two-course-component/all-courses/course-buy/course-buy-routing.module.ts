import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { CourseBuysComponent } from './course-buy/course-buy.component';

const routes: Routes = [
  {
    path: '',
    component: CourseBuysComponent,
  },
];
// path: ':cId/:lavel/:type',
@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class CourseBuyRoutingModule { }
