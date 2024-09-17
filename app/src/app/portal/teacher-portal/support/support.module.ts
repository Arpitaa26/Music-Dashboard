import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { SupportRoutingModule } from './support-routing.module';
import { SupportComponent } from './support/support.component';
import { DateSortPipe } from 'src/app/pipes/date-sort.pipe';


@NgModule({
  declarations: [
    SupportComponent,
    DateSortPipe
  ],
  imports: [
    CommonModule,
    SupportRoutingModule
  ]
})
export class SupportModule { }
 