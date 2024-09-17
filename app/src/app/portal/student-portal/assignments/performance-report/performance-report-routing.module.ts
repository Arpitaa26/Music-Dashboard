import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { PerformanceReportComponent } from './performance-report/performance-report.component';
import { RequestMapper } from 'src/app/request-mapper';

const routes: Routes = [
  {
    path: '',
    component: PerformanceReportComponent,
    children: [
      {
        path: 'coa-cwa-report/:course_id/:course_level_id',
        loadChildren: () =>
          import('./coa-cwa-report/coa-cwa-report.module').then(
            (m) => m.CoaCwaReportModule
          ),
      }
    ],
    // children: [
    //   {
    //     path:RequestMapper.ST_PERFORMANCE_REPORT_BEGINNERS,
    //     loadChildren: () => import('./beginners/beginners.module').then(m => m.BeginnersModule)
    //   },
    //   {
    //     path:RequestMapper.ST_PERFORMANCE_REPORT_INTERMEDIATE,
    //     loadChildren: () => import('./intermediate/intermediate.module').then(m => m.IntermediateModule)
    //   },
    //   {
    //     path:RequestMapper.ST_PERFORMANCE_REPORT_ADVANCE,
    //     loadChildren: () => import('./advance/advance.module').then(m => m.AdvanceModule)
    //   },
    //   {
    //     path:RequestMapper.ST_PERFORMANCE_REPORT_EXPART,
    //     loadChildren: () => import('./expart/expart.module').then(m => m.ExpartModule)
    //   }
    // ]
  },
  
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class PerformanceReportRoutingModule {}
