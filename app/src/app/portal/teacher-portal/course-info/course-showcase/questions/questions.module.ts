import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { QuestionsRoutingModule } from './questions-routing.module';
import { QuestionsComponent } from './questions/questions.component';
import { FormsModule } from '@angular/forms';



@NgModule({
  declarations: [
    QuestionsComponent,
  ],
  imports: [
    CommonModule,
    QuestionsRoutingModule,FormsModule
  ],exports:[QuestionsComponent]
})
export class QuestionsModule { }
