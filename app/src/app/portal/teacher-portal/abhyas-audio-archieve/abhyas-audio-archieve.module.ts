import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { AbhyasAudioArchieveRoutingModule } from './abhyas-audio-archieve-routing.module';
import { AbhyasAudioArchieveComponent } from './abhyas-audio-archieve/abhyas-audio-archieve.component';
import { FormsModule } from '@angular/forms';

@NgModule({
  declarations: [
    AbhyasAudioArchieveComponent
  ],
  imports: [
    CommonModule,
    AbhyasAudioArchieveRoutingModule,
    FormsModule
  ]
})
export class AbhyasAudioArchieveModule { }
