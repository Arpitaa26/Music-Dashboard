import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { SupportComponent } from './support/support.component';
import { RequestMapper } from 'src/app/request-mapper';

const routes: Routes = [
  {
    path: '',
    component: SupportComponent,
  },
  {
    path: RequestMapper.TASK_CREATE,
    loadChildren: () =>
      import('./task-create/task-create.module').then(
        (m) => m.TaskCreateModule
      ),
  },
  {
    path: RequestMapper.TICKET_DETAILS + '/:ticketId',
    loadChildren: () =>
      import('./ticket-detail/ticket-detail.module').then(
        (m) => m.TicketDetailModule
      ),
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class SupportRoutingModule {}
