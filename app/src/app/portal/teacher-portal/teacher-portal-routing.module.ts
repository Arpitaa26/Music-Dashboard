import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { TeacherportalComponent } from './teacher-portal/teacher-portal.component';
import { RequestMapper } from 'src/app/request-mapper';

const routes: Routes = [
  {
    path: '',
    component: TeacherportalComponent,
    children: [
      {
        path: RequestMapper.TEACHERS_DASHBOARD,
        loadChildren: () =>
          import('./dashboard/dashboard.module').then((m) => m.DashboardModule),
      },
      {
        path: RequestMapper.TEACHERS_CLASS_DETAILS,
        loadChildren: () =>
          import('./class-details/class-details.module').then(
            (m) => m.ClassDetailsModule
          ),
      },
      {
        path: RequestMapper.TEACHERS_ASSIGNMENTS,
        loadChildren: () =>
          import('./assignments/assignments.module').then(
            (m) => m.AssignmentsModule
          ),
      },
      {
        path: RequestMapper.COURSE_INFO,
        loadChildren: () =>
          import('./course-info/course-info.module').then(
            (m) => m.CourseInfoModule
          ),
      },
      {
        path: RequestMapper.PERFORMANCE_REPORT,
        loadChildren: () =>
          import('./performance-repo/performance-repo.module').then(
            (m) => m.PerformanceRepoModule
          ),
      },
      {
        path: RequestMapper.TEACHER_PROFILE,
        loadChildren: () =>
          import('./profile/profile.module').then((m) => m.ProfileModule),
      },
      {
        path: RequestMapper.TEACHER_REFERRAL,
        loadChildren: () =>
          import('./referral/referral.module').then((m) => m.ReferralModule),
      },
      {
        path: RequestMapper.SUPPORT,
        loadChildren: () =>
          import('./support/support.module').then((m) => m.SupportModule),
      },
      {
        path:RequestMapper.RESCHDULE_APPROVE,
        loadChildren:()=>
        import('./reschdule-approve/reschdule-approve-routing.module').then((m)=>m.ReschduleApproveRoutingModule)
      },
      {
        path: RequestMapper.TEACHER_PROFILE,
        loadChildren: () =>
          import('./profile/profile.module').then((m) => m.ProfileModule),
      },
      {
        path: RequestMapper.TEACHER_AVAILABILITY,
        loadChildren: () =>
          import('./teacher-availability/teacher-availability.module').then((m) => m.TeacherAvailabilityModule),
      },
  
    ],
    
  },

];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class TeacherportalRoutingModule {}
