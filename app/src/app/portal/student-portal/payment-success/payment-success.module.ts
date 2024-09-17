import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { PaymentSuccessRoutingModule } from './payment-success-routing.module';
import { PaymentSuccessComponent } from './payment-success/payment-success.component';
import { PaymentApiService } from './services/payment.service';


@NgModule({
  declarations: [
    PaymentSuccessComponent
  ],
  imports: [
    CommonModule,
    PaymentSuccessRoutingModule
  ],
  providers:[PaymentApiService]
})
export class PaymentSuccessModule { }
