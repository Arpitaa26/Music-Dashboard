import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { CompletedClassRoutingModule } from './completed-class-routing.module';
import { CompletedClassComponent } from './completed-class/completed-class.component';


@NgModule({
  declarations: [
    CompletedClassComponent
  ],
  imports: [
    CommonModule,
    CompletedClassRoutingModule
  ]
})
export class CompletedClassModule { }
