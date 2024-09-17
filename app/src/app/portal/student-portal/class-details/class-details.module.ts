import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ClassDetailsRoutingModule } from './class-details-routing.module';
import { ClassDetailsComponent } from './class-details/class-details.component';
import { HttpClientModule } from '@angular/common/http';
@NgModule({
  declarations: [
    ClassDetailsComponent
  ],
  imports: [
    CommonModule,
    ClassDetailsRoutingModule,HttpClientModule
  ]
})
export class ClassDetailsModule { }
