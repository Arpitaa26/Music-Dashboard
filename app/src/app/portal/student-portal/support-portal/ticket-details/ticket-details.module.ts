import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { TicketDetailsRoutingModule } from './ticket-details-routing.module';
import { TicketDetailsComponent } from './ticket-details/ticket-details.component';
import { ReactiveFormsModule } from '@angular/forms';
import { CommentSectionModule } from '../comment-section/comment-section.module';

@NgModule({
  declarations: [TicketDetailsComponent],
  imports: [
    CommonModule,
    TicketDetailsRoutingModule,
    ReactiveFormsModule,
    CommentSectionModule,
  ],
})
export class TicketDetailsModule {}
