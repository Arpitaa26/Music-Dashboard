import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { CourseBuyComponent } from './course-buy/course-buy.component';

const routes: Routes = [
  {
    path: ':cId/:lavel/:type',
    component: CourseBuyComponent,
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class CourseBuyRoutingModule { }
