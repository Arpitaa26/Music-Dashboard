import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { RequestMapper } from 'src/app/request-mapper';
import { dashboardComponent } from './dashboard/dashboard.component';

const routes: Routes = [
  {
    path:'',
    component:dashboardComponent,
    children: [
      {
        path: 'my-course',
        loadChildren: () =>
        import('../course-info/course-info.module').then((m) =>m.CourseInfoModule),
      },
    // { path: '', redirectTo: 'my-course', pathMatch: 'full' },
  
      {
        path:'all-courses',
        loadChildren: () =>
        import('../all-courses/all-courses.module').then((m) =>m.AllCoursesModule),
      }
    
    ],
  },
  {
    path: RequestMapper.COURSE_INFO,
    loadChildren: () =>
      import('../two-course-component/two-course-component.module').then(
        (m) => m.TwoCourseComponentModule
      ),
  },
  // {
  //   path: ':class_id_get/:module_name_get/:start_time_get',
  //   component:dashboardComponent
  // }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class DashboardRoutingModule { }
