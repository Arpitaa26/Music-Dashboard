import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AbhyasAudioArchieveComponent } from './abhyas-audio-archieve/abhyas-audio-archieve.component';

const routes: Routes = [
  {
    path: '',
    component: AbhyasAudioArchieveComponent,
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class AbhyasAudioArchieveRoutingModule {}
