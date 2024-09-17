import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { QuestAnsComponent } from './quest-ans/quest-ans.component';

const routes: Routes = [
  {
    path: '',
    component: QuestAnsComponent,
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class QuestAnsRoutingModule {}
