import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { SupportPortalRoutingModule } from './support-portal-routing.module';
import { SupportComponent } from './support/support.component';
import { DateFilterPipePipe } from 'src/app/pipes/date-filter-pipe.pipe';




@NgModule({
  declarations: [SupportComponent,DateFilterPipePipe],
  imports: [CommonModule, SupportPortalRoutingModule,],
})
export class SupportPortalModule {}
