import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { AudioArchiveRoutingModule } from './audio-archive.routing.module';
import { AudioArchiveComponent } from './audio-archive/audio-archive.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { ComponentModule } from 'src/app/component/component.module';


@NgModule({
  declarations: [
    AudioArchiveComponent
  ],
  imports: [
    CommonModule,
    AudioArchiveRoutingModule,ReactiveFormsModule,FormsModule,ComponentModule
  ]
})
export class AudioArchiveModule { }
