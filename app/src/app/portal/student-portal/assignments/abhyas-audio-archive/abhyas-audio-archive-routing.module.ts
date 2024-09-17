import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AbhyasAudioArchiveComponent } from './abhyas-audio-archive/abhyas-audio-archive.component';

const routes: Routes = [
  {
    path:'',
    component:AbhyasAudioArchiveComponent
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class AbhyasAudioArchiveRoutingModule { }
