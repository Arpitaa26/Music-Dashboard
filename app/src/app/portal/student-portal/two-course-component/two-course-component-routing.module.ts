import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { TwoCourseComponentComponent } from './two-course-component/two-course-component.component';

const routes: Routes = [
  {
    path: '',
     component: TwoCourseComponentComponent,
    children: [
      {
        path: 'my-course',
        loadChildren: () =>
        import('./course-info/course-info.module').then((m) =>m.CourseInfoModule),
      },
      {
        path:'all-courses',
        loadChildren: () =>
        import('./all-courses/all-courses.module').then((m) =>m.AllCoursesModule),
      },
      { path: '', redirectTo: 'my-course', pathMatch: 'full' },
    
    ],
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],

})
export class TwoCourseComponentRoutingModule { }
