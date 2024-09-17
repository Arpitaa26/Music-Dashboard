import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { CourseShowcaseComponent } from './course-showcase/course-showcase.component';

const routes: Routes = [
  {
    path: '',
    component: CourseShowcaseComponent,
    // children: [
    //   {
    //     path: 'overview',
    //     loadChildren: () =>
    //       import('./overview/overview.module').then((m) => m.OverviewModule),
    //   },
    //   // {
    //   //   path: '',
    //   //   redirectTo: 'overview',
    //   //   pathMatch: 'full',
    //   // },
    //   {
    //     path: 'questans',
    //     loadChildren: () =>
    //       import('./quest-ans/quest-ans.module').then((m) => m.QuestAnsModule),
    //   },
    // ],
  },
  // {
  //   path: 'overview',
  //   loadChildren: () =>
  //     import('./overview/overview.module').then((m) => m.OverviewModule),
  // },
  // {
  //   path: 'questans',
  //   loadChildren: () =>
  //     import('./quest-ans/quest-ans.module').then((m) => m.QuestAnsModule),
  // },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class CourseShowcaseRoutingModule {}
