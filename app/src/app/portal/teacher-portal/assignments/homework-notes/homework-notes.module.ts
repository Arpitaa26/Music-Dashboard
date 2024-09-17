import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { HomeworkNotesRoutingModule } from './homework-notes-routing.module';
import { HomeworkNotesComponent } from './homework-notes/homework-notes.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { ComponentModule } from 'src/app/component/component.module';

@NgModule({
  declarations: [
    HomeworkNotesComponent
  ],
  imports: [
    CommonModule,
    HomeworkNotesRoutingModule,
    FormsModule, ReactiveFormsModule,ComponentModule
  ]
})
export class HomeworkNotesModule { }
