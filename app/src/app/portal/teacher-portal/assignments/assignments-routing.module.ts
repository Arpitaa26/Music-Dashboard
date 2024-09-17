import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AssignmentComponent } from './assignment/assignment.component';

const routes: Routes = [
  {
    path: '',
    component: AssignmentComponent,
    children: [
      // {
      //   path: 'performa_report',
      //   loadChildren: () =>
      //     import('./performance-repo/performance-repo.module').then(
      //       (m) => m.PerformanceRepoModule
      //     ),
      // },
      {
        path: '',
        redirectTo: 'audio_archive',
        pathMatch: 'full',
      },
      {
        path: 'homework_notes',
        loadChildren: () =>
          import('./homework-notes/homework-notes.module').then(
            (m) => m.HomeworkNotesModule
          ),
      },
      {
        path: 'audio_archive',
        loadChildren: () =>
          import('./audio-archive/audio-archive.module').then(
            (m) => m.AudioArchiveModule
          ),
      },
    ],
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class AssignmentsRoutingModule {}
