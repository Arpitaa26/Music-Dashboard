import { RequestMapper } from "src/app/request-mapper"
import { Assignments } from "../interface/assignments"

export class AssignmentsMenu {
  private static readonly _assignmentMenu1:Assignments = {
    link:RequestMapper.STUDENTS_HOMEWORK_TEACHERS_NOTE,
    text:"Homework and Teachers Note",
    id:"h_t_n"
  }
  // private static readonly _assignmentMenu2:Assignments = {
  //   link:RequestMapper.STUDENTS_PERFORMANCE_REPORT,
  //   text:"Performance Report",
  //   id:"performance_report"
  // }
  private static readonly _assignmentMenu3:Assignments = {
    link:RequestMapper.ABHYAS_AUDIO_ARCHIVE,
    text:"Abhyasa Archive",
    id:"performance_report"
  }
  public static get menuMethod(){
    return [
      AssignmentsMenu._assignmentMenu1,
      // AssignmentsMenu._assignmentMenu2,
      AssignmentsMenu._assignmentMenu3,
    ]
  }
}
