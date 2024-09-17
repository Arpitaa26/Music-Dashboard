import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { TicketDetailRoutingModule } from './ticket-detail-routing.module';
import { TicketDetailComponent } from './ticket-detail/ticket-detail.component';
import { ReactiveFormsModule } from '@angular/forms';
import { CommentSectionModule } from '../comment-section/comment-section.module';

@NgModule({
  declarations: [TicketDetailComponent],
  imports: [
    CommonModule,
    TicketDetailRoutingModule,
    ReactiveFormsModule,
    CommentSectionModule,
  ],
})
export class TicketDetailModule {}
