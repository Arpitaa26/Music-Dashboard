import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {
  CommentSectionComponent,
  DateSort2Pipe,
} from './comment-section/comment-section.component';
import { ReactiveFormsModule } from '@angular/forms';
import { CustomdatedatePipe, CustomdatedatePipechat, CustomdatePipe } from 'src/app/date/customdate.pipe';

@NgModule({
  declarations: [CommentSectionComponent,CustomdatedatePipechat],
  imports: [CommonModule, ReactiveFormsModule],
  exports: [CommentSectionComponent],
})
export class CommentSectionModule {}
