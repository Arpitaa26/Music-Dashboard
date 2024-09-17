import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { PerformanceRepoComponent } from './performance-repo/performance-repo.component';

const routes: Routes = [
  {
    path: '',
    component: PerformanceRepoComponent,
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class PerformanceRepoRoutingModule {}
