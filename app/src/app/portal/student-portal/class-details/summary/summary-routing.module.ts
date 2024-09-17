import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { summaryComponent } from './summary/summary.component';

const routes: Routes = [
  {
    path:'',
    component:summaryComponent
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class summaryRoutingModule { }
