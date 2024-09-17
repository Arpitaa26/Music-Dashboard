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
        path: 'calender_view',
        loadChildren: () =>
          import('./calenderview/calenderview.module').then(
            (m) => m.CalenderviewModule
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
          import('./summary/summary.module').then((m) => m.summaryModule),
      },
      
    ],
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ClassDetailsRoutingModule {}
