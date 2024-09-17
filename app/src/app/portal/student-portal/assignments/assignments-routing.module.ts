import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AssignmentsComponent } from './assignments/assignments.component';
import { RequestMapper } from 'src/app/request-mapper';

const routes: Routes = [
  {
    path: '',
    component: AssignmentsComponent,
    children: [
      {
        path: '',
        redirectTo: RequestMapper.STUDENTS_HOMEWORK_TEACHERS_NOTE,
        pathMatch: 'full',
      },
      {
        path: RequestMapper.STUDENTS_PERFORMANCE_REPORT,
        loadChildren: () =>
          import('./performance-report/performance-report.module').then(
            (m) => m.PerformanceReportModule
          ),
      },
      {
        path: RequestMapper.STUDENTS_HOMEWORK_TEACHERS_NOTE,
        loadChildren: () =>
          import('./homework-teachers-note/homework-teachers-note.module').then(
            (m) => m.HomeworkTeachersNoteModule
          ),
      },
      {
        path: RequestMapper.ABHYAS_AUDIO_ARCHIVE,
        loadChildren: () =>
          import('./abhyas-audio-archive/abhyas-audio-archive.module').then(
            (m) => m.AbhyasAudioArchiveModule
          ),
      }
      // {
      //   path: 'coa-cwa-report',
      //   loadChildren: () =>
      //     import('../assignments/performance-report/coa-cwa-report/coa-cwa-report.module').then(
      //       (m) => m.CoaCwaReportModule
      //     ),
      // },
    ],
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class AssignmentsRoutingModule {}
