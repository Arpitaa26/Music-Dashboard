import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { TaskCreateComponent } from './task-create/task-create.component';

const routes: Routes = [
  {
    path: '',
    component: TaskCreateComponent,
  },
  {
    path: ':class_id_get/:module_name_get/:start_time_get',
    component: TaskCreateComponent,
  }
];
// path: ':class_id_get/:module_name_get/:start_time_get',
@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class TaskCreateRoutingModule {}


