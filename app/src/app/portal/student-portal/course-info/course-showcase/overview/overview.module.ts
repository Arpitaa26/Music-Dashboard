import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { OverviewRoutingModule } from './overview-routing.module';
import { OverviewComponent } from './overview/overview.component';

@NgModule({
  declarations: [OverviewComponent],
  exports: [OverviewComponent],
  imports: [CommonModule, OverviewRoutingModule],
})
export class OverviewModule {}
