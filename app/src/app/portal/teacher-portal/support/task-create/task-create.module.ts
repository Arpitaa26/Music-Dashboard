import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';

import { TaskCreateRoutingModule } from './task-create-routing.module';
import { TaskCreateComponent } from './task-create/task-create.component';
import { ComponentModule } from 'src/app/component/component.module';

@NgModule({
  declarations: [TaskCreateComponent],
  imports: [CommonModule, TaskCreateRoutingModule, ReactiveFormsModule,ComponentModule],
})
export class TaskCreateModule {}
