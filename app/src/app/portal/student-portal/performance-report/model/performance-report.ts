import { RequestMapper } from "src/app/request-mapper"
import { PerformanceReportInterface } from "../interface/performance-report"

export class PerformanceReport {
  private static readonly _pr1:PerformanceReportInterface = {
    link:RequestMapper.ST_PERFORMANCE_REPORT_BEGINNERS,
    text:"Beginners",
    id:"p_r_b"
  }
  private static readonly _pr2:PerformanceReportInterface = {
    link:RequestMapper.ST_PERFORMANCE_REPORT_ADVANCE,
    text:"Advance",
    id:"p_r_a"
  }
  private static readonly _pr3:PerformanceReportInterface = {
    link:RequestMapper.ST_PERFORMANCE_REPORT_INTERMEDIATE,
    text:"intermediate",
    id:"p_r_i"
  }
  private static readonly _pr4:PerformanceReportInterface = {
    link:RequestMapper.ST_PERFORMANCE_REPORT_EXPART,
    text:"expart",
    id:"p_r_e"
  }
  public static get menuMethod(){
    return [
      PerformanceReport._pr1,
      PerformanceReport._pr3,
      PerformanceReport._pr2,
      PerformanceReport._pr4,
    ]
  }
}
