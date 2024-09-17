import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { UpdatePasswordRoutingModule } from './update-password-routing.module';
// import { UpdatePasswordComponent } from './update-password/update-password.component';
import { FormsModule, NgForm, ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { BrowserModule } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { UpdatePasswordComponent } from './update-password/update-password.component';


@NgModule({
  declarations: [
     UpdatePasswordComponent
  ],
  imports: [
    CommonModule,
    UpdatePasswordRoutingModule,HttpClientModule,
    BrowserModule,
    BrowserAnimationsModule,ReactiveFormsModule,NgModule,

  ]
})
export class UpdatePasswordModule { }
