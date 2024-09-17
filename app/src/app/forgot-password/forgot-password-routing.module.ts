import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ForgotPasswordComponent } from './forgot-password/forgot-password.component';

const routes: Routes = [

  {
    path: '',
    component: ForgotPasswordComponent,
    // children:[
    //   {
    //     path:'updatePwd',
    //     loadChildren: () =>
    //     import('./update-password/update-password.module').then(
    //       (m) => m.UpdatePasswordModule
    //     ),
    //   }
    // ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ForgotPasswordRoutingModule {}
