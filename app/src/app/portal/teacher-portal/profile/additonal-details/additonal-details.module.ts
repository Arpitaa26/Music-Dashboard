import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { AdditonalDetailsRoutingModule } from './additonal-details-routing.module';
import { AdditionalDetailsComponent } from './additional-details/additional-details.component';
import { ReactiveFormsModule } from '@angular/forms';


@NgModule({
  declarations: [
    AdditionalDetailsComponent
  ],
  imports: [
    CommonModule,
    AdditonalDetailsRoutingModule,ReactiveFormsModule
  ]
})
export class AdditonalDetailsModule { }
