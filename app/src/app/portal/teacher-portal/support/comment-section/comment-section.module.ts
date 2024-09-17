import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { CommentSectionComponent } from './comment-section/comment-section.component';
import { ReactiveFormsModule } from '@angular/forms';

@NgModule({
  declarations: [CommentSectionComponent],
  imports: [CommonModule, ReactiveFormsModule],
  exports: [CommentSectionComponent],
})
export class CommentSectionModule {}
