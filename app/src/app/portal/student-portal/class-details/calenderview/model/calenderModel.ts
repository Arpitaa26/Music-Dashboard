import { CalenderInfoInterface } from '../interface/calenderInterface';

export class CalenderInfoModel {
  private static readonly calenderInfoObj: CalenderInfoInterface[] = [
    // {
    //     start: "subDays(new Date(), 1)",
    //   end: "addDays(new Date(), 1)",
    //   title: 'A 3 day event',
    //   color: "{ ...colors['red'] }",
    //   actions: "this.actions",
    //   allDay: true,
    //   resizable: {
    //     beforeStart: true,
    //     afterEnd: true,
    //   },
    //   draggable: true,
    // },
    {
      id: '01',
      start: 4,
      end: 10,
      tip: 'This event starts from 4th of this month to 10 of this Month',
      color: 'red',
      title: 'Harmonium chord Practice',
    },
    {
      id: '02',
      start: 8,
      end: 15,
      tip: 'This event starts from 8th of this month to 15 of this Month',
      color: 'yellow',
      title: 'Guitar chord Practice',
    },
    {
      id: '03',
      start: 6,
      end: 0,
      tip: 'This event starts from 6th of this month and ends same day',
      color: 'red',
      title: 'Guitar scale revision',
    },
    {
      id: '04',
      start: 15,
      end: 20,
      tip: 'This event starts from 15th of this month to 20 of this Month',
      color: 'blue',
      title: 'Violin tuning Demo',
    },
    {
      id: '05',
      start: 25,
      end: 28,
      tip: 'This event starts from 25th of this month to 28 of this Month',
      color: 'yellow',
      title: 'Harmonium chord Practice',
    },
  ];

  public static get returnMethod() {
    return CalenderInfoModel.calenderInfoObj;
  }
}
