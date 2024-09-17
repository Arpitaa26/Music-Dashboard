import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AudioArchiveComponent } from './audio-archive/audio-archive.component';

const routes: Routes = [
  {
    path: '',
    component: AudioArchiveComponent,
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class AudioArchiveRoutingModule {}
