import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { dashboardComponent } from 'src/app/portal/student-portal/dashboard/dashboard/dashboard.component';
import { RequestMapper } from 'src/app/request-mapper';
import { CalendarviewComponent } from './calendarview/calendarview.component';

const routes: Routes = [
  {
    path: '',
    component: CalendarviewComponent,
  },
  {
    path: 'dashboard',
    loadChildren: () =>
      import('../../dashboard/dashboard.module').then((m) => m.DashboardModule),
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class CalendarviewRoutingModule {}
