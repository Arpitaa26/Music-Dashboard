import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { AbhyasAudioArchiveRoutingModule } from './abhyas-audio-archive-routing.module';
import { AbhyasAudioArchiveComponent } from './abhyas-audio-archive/abhyas-audio-archive.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { BrowserModule } from '@angular/platform-browser';

@NgModule({
  declarations: [AbhyasAudioArchiveComponent],
  imports: [
    CommonModule,
    AbhyasAudioArchiveRoutingModule,
    FormsModule,
    HttpClientModule,
    ReactiveFormsModule,
  ],
})
export class AbhyasAudioArchiveModule {}
