import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AdditionalDetailsComponent } from './additional-details/additional-details.component';

const routes: Routes = [
  {
    path: '',
    component: AdditionalDetailsComponent,
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class AdditonalDetailsRoutingModule { }
