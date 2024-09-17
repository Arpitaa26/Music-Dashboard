import { Component, NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { TeacherProfileComponent } from './profile-info/teacher-profile/teacher-profile.component';
import { ProfileComponent } from './profile/profile.component';

const routes: Routes = [
  {
    path: '',
    component: ProfileComponent,
    children: [
      {
        path: 'teacher-profile',
        loadChildren: () =>
        import('./profile-info/profile-info.module').then((m) =>m.ProfileInfoModule),
      },
      {
        path:'additainal-details',
        loadChildren: () =>
        import('./additonal-details/additonal-details.module').then((m) =>m.AdditonalDetailsModule
          ),
      },
      {
        path:'teacher-availability',
        loadChildren: () =>
        import('../teacher-availability/teacher-availability.module').then((m) =>m.TeacherAvailabilityModule
          ),
      }
    
    ],
  },
  // {
  //   path:'teacher-profile',component:TeacherProfileComponent
  // },
  // {
  //   path: 'teacher-profile',
  //   loadChildren: () =>
  //     import('./profile-info/teacher-profile.module').then((m) =>m.ProfileInfoModule),
  // }
  
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ProfileRoutingModule {}
