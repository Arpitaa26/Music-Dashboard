import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ClassDetailsComponent } from './class-details/class-details.component';

const routes: Routes = [
  {
    path: '',
    component: ClassDetailsComponent,
    children: [
      {
        path: 'schedule_class',
        loadChildren: () =>
          import('./scheduleclass/scheduleclass.module').then(
            (m) => m.ScheduleclassModule
          ),
      },
      {
        path: 'completed_class',
        loadChildren: () =>
          import('./completed-class/completed-class.module').then(
            (m) => m.CompletedClassModule
          ),
      },
      {
        path: '',
        redirectTo: 'calender_view',
        pathMatch: 'full',
      },
      {
        path: 'summary',
        loadChildren: () =>
          import('./summary/summary.module').then((m) => m.SummaryModule),
      },
      {
        path: 'calender_view',
        loadChildren: () =>
          import('./calendarview/calendarview.module').then(
            (m) => m.CalendarviewModule
          ),
      },
    ],
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ClassDetailsRoutingModule {}
