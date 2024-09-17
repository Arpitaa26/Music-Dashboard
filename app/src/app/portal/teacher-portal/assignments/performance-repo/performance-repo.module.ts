import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { PerformanceRepoRoutingModule } from './performance-repo-routing.module';
import { PerformanceRepoComponent } from './performance-repo/performance-repo.component';


@NgModule({
  declarations: [
    PerformanceRepoComponent
  ],
  imports: [
    CommonModule,
    PerformanceRepoRoutingModule,
  ]
})
export class PerformanceRepoModule { }
