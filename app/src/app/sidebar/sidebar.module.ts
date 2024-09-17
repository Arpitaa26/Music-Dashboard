import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SidebarComponent } from './sidebar/sidebar.component';
// import { Router } from '@angular/router';
import { AppRoutingModule } from '../app-routing.module';
import { RouterModule } from '@angular/router';



@NgModule({
  declarations: [
    SidebarComponent
  ],
  imports: [
    CommonModule,
    // AppRoutingModule
    RouterModule
  ],
  exports:[
    SidebarComponent,

  ]
})
export class SidebarModule { }
