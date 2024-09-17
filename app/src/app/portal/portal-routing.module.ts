import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { RequestMapper } from '../request-mapper';
import { AuthGuard } from '../guard/auth.guard';
import { roleGuard } from '../guard/role.guard';
const routes: Routes = [
  {
    path: RequestMapper.TEACHERS_PORTAL,
    canActivate: [AuthGuard, roleGuard],
    data: {
      role: 'TEACHER',
    },
    loadChildren: () =>
      import('./teacher-portal/teacher-portal.module').then(
        (m) => m.TeacherportalModule
      ),
  },
  {
    path: RequestMapper.STUDENT_PORTAL,
    canActivate: [AuthGuard, roleGuard],
    data: {
      role: 'STUDENT',
    },
    loadChildren: () =>
      import('./student-portal/student-portal.module').then(
        (m) => m.StudentPortalModule
      ),
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class PortalRoutingModule {}
