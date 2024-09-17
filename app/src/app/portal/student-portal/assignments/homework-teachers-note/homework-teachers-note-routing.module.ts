import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeworkTeachersNoteComponent } from './homework-teachers-note/homework-teachers-note.component';

const routes: Routes = [
  {
    path:'',
    component:HomeworkTeachersNoteComponent,
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class HomeworkTeachersNoteRoutingModule { }
