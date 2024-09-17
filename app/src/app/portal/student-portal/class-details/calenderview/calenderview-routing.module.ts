import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { dashboardComponent } from '../../dashboard/dashboard/dashboard.component';
import { CalenderviewComponent } from './calenderview/calenderview.component';

const routes: Routes = [
  {
    path:'',
    component:CalenderviewComponent
  },
  {
    path:'portal/students/dashboard',
    component:dashboardComponent
  },
  // {
  //   path: 'dashboard',
  //   loadChildren: () =>
  //     import('../../dashboard/dashboard.module').then((m) => m.DashboardModule),
  // },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class CalenderviewRoutingModule { }
