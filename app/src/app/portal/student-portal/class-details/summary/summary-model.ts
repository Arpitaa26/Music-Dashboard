import { summaryInteface } from './summary-interface';
export class summaryModel {
  private static readonly summaryObj: summaryInteface[] = [
    {
      class_name: 'Class #1',
      scheduled_class: 'Monday, 23 May 2023. 04:00 PM',
      teacher_name: 'Kritika Iyer',
      rescheduled: false,
      rescheduled_date: 'Not Rescheduled',
      hourwok: 'acasca ascascas ascascsa ascasas ',
      teacher_note: 'acasca ascascas ascascsa',
      id: '01',
      full_name: 'Brinda',
    },
    {
      class_name: 'Class #2',
      scheduled_class: 'Monday, 23 May 2023. 04:00 PM',
      teacher_name: 'Kritika Iyer',
      rescheduled: false,
      rescheduled_date: 'Not Rescheduled',
      hourwok: 'acasca ascascas ascascsa ascasas ',
      teacher_note: 'acasca ascascas ascascsa',
      id: '02',
      full_name: 'Brinda',
    },
    {
      class_name: 'Class #3',
      scheduled_class: 'Monday, 23 May 2023. 04:00 PM',
      teacher_name: 'Kritika Iyer',
      rescheduled: false,
      rescheduled_date: 'Not Rescheduled',
      hourwok: 'acasca ascascas ascascsa ascasas ',
      teacher_note: 'acasca ascascas ascascsa',
      id: '03',
      full_name: 'Brinda',
    },
    {
      class_name: 'Class #4',
      scheduled_class: 'Monday, 23 May 2023. 04:00 PM',
      teacher_name: 'Kritika Iyer',
      rescheduled: false,
      rescheduled_date: 'Not Rescheduled',
      hourwok: 'acasca ascascas ascascsa ascasas ',
      teacher_note: 'acasca ascascas ascascsa',
      id: '04',
      full_name: 'Brinda',
    },
    {
      class_name: 'Class #5',
      scheduled_class: 'Monday, 23 May 2023. 04:00 PM',
      teacher_name: 'Kritika Iyer',
      rescheduled: false,
      rescheduled_date: 'Not Rescheduled',
      hourwok: 'acasca ascascas ascascsa ascasas ',
      teacher_note: 'acasca ascascas ascascsa',
      id: '05',
      full_name: 'Brinda',
    },
  ];

  public static get returnMethod() {
    return summaryModel.summaryObj;
  }
}
