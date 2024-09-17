import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ModuleListRoutingModule } from './module-list-routing.module';
import { ModuleListComponent } from './module-list/module-list.component';


@NgModule({
  declarations: [
    ModuleListComponent
  ],
  imports: [
    CommonModule,
    ModuleListRoutingModule
  ]
})
export class ModuleListModule { }

