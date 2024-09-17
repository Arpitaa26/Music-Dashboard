import { NgModule } from '@angular/core';
import { CommonModule, NgFor } from '@angular/common';

import { ReschduleApproveRoutingModule } from './reschdule-approve-routing.module';
import { ReschduleApproveComponent } from './reschdule-approve/reschdule-approve.component';
import { FormsModule, NgForm, ReactiveFormsModule } from '@angular/forms';
import { BrowserModule } from '@angular/platform-browser';


@NgModule({
  declarations: [
    ReschduleApproveComponent
  ],
  imports: [
    CommonModule,
    ReschduleApproveRoutingModule,BrowserModule, FormsModule,NgModule
  ]
})
export class ReschduleApproveModule { }
