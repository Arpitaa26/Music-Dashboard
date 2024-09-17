import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ClassDetailsRoutingModule } from './class-details-routing.module';
import { ClassDetailsComponent } from './class-details/class-details.component';
import { ReactiveFormsModule } from '@angular/forms';
@NgModule({
  declarations: [ClassDetailsComponent],
  imports: [CommonModule, ClassDetailsRoutingModule],
})
export class ClassDetailsModule {}
