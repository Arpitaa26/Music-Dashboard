import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { SummaryRoutingModule } from './summary-routing.module';
import { SummaryComponent } from './summary/summary.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { ComponentModule } from 'src/app/component/component.module';


@NgModule({
  declarations: [
    SummaryComponent
  ],
  imports: [
    CommonModule,
    SummaryRoutingModule,
    FormsModule,ReactiveFormsModule,ComponentModule
  ]
})
export class SummaryModule { }
