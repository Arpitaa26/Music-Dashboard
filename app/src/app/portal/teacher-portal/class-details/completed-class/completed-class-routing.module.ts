import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { CompletedClassComponent } from './completed-class/completed-class.component';

const routes: Routes = [
  {
    path: '',
    component: CompletedClassComponent,
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class CompletedClassRoutingModule {}
