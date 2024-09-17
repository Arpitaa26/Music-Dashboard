import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeworkNotesComponent } from './homework-notes/homework-notes.component';

const routes: Routes = [
  {
    path: '',
    component: HomeworkNotesComponent,
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class HomeworkNotesRoutingModule {}
