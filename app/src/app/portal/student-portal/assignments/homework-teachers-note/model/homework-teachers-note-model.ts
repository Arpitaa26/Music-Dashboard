import { HomeworkTeachersNote } from '../interface/homework-teachers-note';

export class HomeworkTeachersNoteModel {
  private static readonly _htn1: HomeworkTeachersNote = {
    className: 'Class #10',
    homework: 'Dummy home work 1',
    teachersNote: 'Dummy Teachers Note 1',
    date: 'Monday, 23 May 2023. 04:00 PM',
  };
  private static readonly _htn2: HomeworkTeachersNote = {
    className: 'Class #20',
    homework: 'Dummy home work 2',
    teachersNote: 'Dummy Teachers Note 2',
    date: 'Monday, 23 May 2023. 04:00 PM',
  };
  private static readonly _htn3: HomeworkTeachersNote = {
    className: 'Class #30',
    homework: 'Dummy home work 3',
    teachersNote: 'Dummy Teachers Note 3',
    date: 'Monday, 23 May 2023. 04:00 PM',
  };
  public static get methodHtnl() {
    return [
      HomeworkTeachersNoteModel._htn1,
      HomeworkTeachersNoteModel._htn2,
      HomeworkTeachersNoteModel._htn3,
    ];
  }
}
