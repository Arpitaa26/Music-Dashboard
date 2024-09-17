import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ReferralRoutingModule } from './referral-routing.module';
import { ReferralComponent } from './referral/referral.component';


@NgModule({
  declarations: [
    ReferralComponent
  ],
  imports: [
    CommonModule,
    ReferralRoutingModule
  ]
})
export class ReferralModule { }
