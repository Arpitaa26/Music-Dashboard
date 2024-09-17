import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ScheduleclassComponent } from './scheduleclass/scheduleclass.component';

const routes: Routes = [
  {
    path: ':date',
    component: ScheduleclassComponent,
  },
  {
    path: '',
    component: ScheduleclassComponent,
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ScheduleclassRoutingModule {}
