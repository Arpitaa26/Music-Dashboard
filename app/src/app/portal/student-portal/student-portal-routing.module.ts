import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { StudentPortalComponent } from './student-portal/student-portal.component';
import { RequestMapper } from '../../request-mapper';
const routes: Routes = [
  {
    path: '',
    component: StudentPortalComponent,
    children: [
      {
        path: RequestMapper.STUDENTS_DASHBOARD,
        loadChildren: () =>
          import('./dashboard/dashboard.module').then((m) => m.DashboardModule),
      },
      {
        path: RequestMapper.STUDENTS_CLASS_DETAILS,
        loadChildren: () =>
          import('./class-details/class-details.module').then(
            (m) => m.ClassDetailsModule
          ),
      },
      {
        path: RequestMapper.STUDENTS_ASSIGNMENTS,
        loadChildren: () =>
          import('./assignments/assignments.module').then(
            (m) => m.AssignmentsModule
          ),
      },
      {
        path: RequestMapper.COURSE_INFO,
        loadChildren: () =>
          import('./two-course-component/two-course-component.module').then(
            (m) => m.TwoCourseComponentModule
          ),
      },
      {
        path: RequestMapper.SUPPORT,
        loadChildren: () =>
          import('./support-portal/support-portal.module').then(
            (m) => m.SupportPortalModule
          ),
      },
      {
        path: RequestMapper.PROFILE,
        loadChildren: () =>
          import('../../profile/profile.module').then((m) => m.ProfileModule),
      },
      // {
      //   path: RequestMapper.PERFORMANCE_REPORT,
      //   loadChildren: () =>
      //     import('./performance-repo/performance-repo.module').then(
      //       (m) => m.PerformanceRepoModule
      //     ),
      // },
      {
        path: RequestMapper.TEACHER_REFERRAL,
        loadChildren: () =>
          import('./referral/referral.module').then((m) => m.ReferralModule),
      },
      {
        path: RequestMapper.ALL_COURSES,
        loadChildren: () =>
          import('./all-courses/all-courses.module').then((m) => m.AllCoursesModule),
      },
      {
        path: RequestMapper.STUDENT_PROFILE,
        loadChildren: () =>
          import('../student-portal/profile/profile.module').then((m) => m.ProfileModule),
      },
      {
        path: RequestMapper.ABHYAS_AUDIO_ARCHIVE,
        loadChildren: () =>
          import('./abhyas-audio-archive/abhyas-audio-archive.module').then(
            (m) => m.AbhyasAudioArchiveModule
          ),
      },
      {
        path: RequestMapper.PERFORMANCE_REPORT,
        loadChildren: () =>
          import('./performance-report/performance-report.module').then(
            (m) => m.PerformanceReportModule
          ),
      },
      {
        path: 'payment-status',
        loadChildren: () =>
          import('./payment-success/payment-success.module').then(
            (m) => m.PaymentSuccessModule
          ),
      },


      
      
    ],
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class StudentPortalRoutingModule {}
