import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { summaryRoutingModule } from './summary-routing.module';
import { summaryComponent } from './summary/summary.component';
import { summaryModel } from './summary-model';
import { FormsModule, NgForm,ReactiveFormsModule} from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';


@NgModule({
  declarations: [
    summaryComponent,
  ],
  imports: [
    CommonModule,
    summaryRoutingModule,FormsModule,HttpClientModule,ReactiveFormsModule
  ]
})
export class summaryModule { }
