import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { PaymentSuccessComponent } from './payment-success/payment-success.component';

const routes: Routes = [
  {
    path:':refId',component:PaymentSuccessComponent
  },
  {
  path:'dashboard',
  loadChildren: () =>
    import('../dashboard/dashboard.module').then((m) => m.DashboardModule),
},
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class PaymentSuccessRoutingModule { }
