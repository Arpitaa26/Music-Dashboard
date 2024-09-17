import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { HomeworkTeachersNoteRoutingModule } from './homework-teachers-note-routing.module';
import { HomeworkTeachersNoteComponent } from './homework-teachers-note/homework-teachers-note.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
// import { HomeworkTeachersNoteModelComponent } from './model/homework-teachers-note-model/homework-teachers-note-model.component';


@NgModule({
  declarations: [
    HomeworkTeachersNoteComponent,
  ],
  imports: [
    CommonModule,
    HomeworkTeachersNoteRoutingModule,
    FormsModule,ReactiveFormsModule
  ]
})
export class HomeworkTeachersNoteModule { }
