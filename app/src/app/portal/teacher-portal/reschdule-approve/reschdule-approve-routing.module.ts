import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ReschduleApproveComponent } from './reschdule-approve/reschdule-approve.component';

const routes: Routes = [
  {
    path:'',component:ReschduleApproveComponent
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class ReschduleApproveRoutingModule { }
