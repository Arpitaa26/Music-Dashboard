import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SucessComponent } from './sucess/sucess.component';
import { DangerComponent } from './danger/danger.component';



@NgModule({
  declarations: [
    SucessComponent,
    DangerComponent
  ],
  imports: [
    CommonModule
  ],
  exports:[
    SucessComponent,DangerComponent
  ]
})
export class ComponentModule { }
