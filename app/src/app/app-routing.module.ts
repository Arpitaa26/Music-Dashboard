import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';


// import { ForgotPasswordComponent } from './forgot-password/forgot-password.component';
import { TeacherProfileComponent } from './portal/teacher-portal/profile/profile-info/teacher-profile/teacher-profile.component';
import { RequestMapper } from './request-mapper';
import { UpdatePasswordComponent } from './update-password/update-password/update-password.component';
import { UpdateProfileComponent } from './update-profile/update-profile.component';

const routes: Routes = [
  {
    path: RequestMapper.LOGIN,
    loadChildren: () =>
      import('./login/login.module').then((m) => m.LoginModule),
  },
  {
    path: RequestMapper.SIGNUP,
    loadChildren: () =>
      import('./signup/signup.module').then((m) => m.SignupModule),
  },
  {
    path: RequestMapper.LOGOUT,
    loadChildren: () =>
      import('./logout/logout.module').then((m) => m.LogoutModule),
  },
  // {
  //   path: RequestMapper.ALL_COURSES,
  //   loadChildren: () =>
  //     import('./course-all/course-all.module').then((m) => m.CourseAllModule),
  // },
  {
    path: RequestMapper.PORTAL,
    loadChildren: () =>
      import('./portal/portal.module').then((m) => m.PortalModule),
  },
  // {
  //   path: RequestMapper.NOT_FOUND_URL,
  //   loadChildren: () =>
  //     import('./notfound/notfound.module').then((m) => m.NotfoundModule),
  // },
  {
    path: RequestMapper.LOGOUT,
    loadChildren: () =>
      import('./logout/logout.module').then((m) => m.LogoutModule),
  },

  {
    path: 'forgot_password',
    loadChildren: () =>
      import('./forgot-password/forgot-password.module').then(
        (m) => m.ForgotPasswordModule
      ),
  },
  // {
  //   path: 'forgot_password',
  //   component: ForgotPasswordComponent,
  // },
  {
    path: 'update_profile',
    component: UpdateProfileComponent,
  },{
    path:'updatepassword/:id/:token',component:UpdatePasswordComponent
  },
  

  // {
  //   path: RequestMapper.ABHYAS_AUDIO_ARCHIVE,
  //   loadChildren: () => import('./../app/portal/student-portal/abhyas-audio-archive/abhyas-audio-archive.module').then(m =>m.AbhyasAudioArchiveModule)
  // },

  // {
  //   path: 'abhyas_audio_archive',component:AbhyasAudioArchiveComponent
  // },
  // {
  //   path:RequestMapper.STUDENT_GALLERY,loadChildren: () => import('./student-gallery/student-gallery.module').then(m => m.StudentGalleryModule)
  // },

  // {
  // 	path: RequestMapper.PROFILE,
  // 	loadChildren: () => import('./profile/profile.module').then(m => m.ProfileModule)
  // },
  {
    path: '**',
    redirectTo: RequestMapper.NOT_FOUND_URL,
    pathMatch: 'full',
  },
  {
    path: '',
    redirectTo: RequestMapper.LOGIN,
    pathMatch: 'full',
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule],
})
export class AppRoutingModule {}
