import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { QuestAnsRoutingModule } from './quest-ans-routing.module';
import { QuestAnsComponent } from './quest-ans/quest-ans.component';

@NgModule({
  declarations: [QuestAnsComponent],
  imports: [CommonModule, QuestAnsRoutingModule],
  exports: [QuestAnsComponent],
})
export class QuestAnsModule {}
