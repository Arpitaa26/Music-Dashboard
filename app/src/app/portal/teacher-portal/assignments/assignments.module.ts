import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { AssignmentsRoutingModule } from './assignments-routing.module';
import { AssignmentComponent } from './assignment/assignment.component';

import { FormsModule } from '@angular/forms';

@NgModule({
  declarations: [
    AssignmentComponent
  ],
  imports: [
    CommonModule,
    AssignmentsRoutingModule,
    FormsModule
  ]
})
export class AssignmentsModule { }
