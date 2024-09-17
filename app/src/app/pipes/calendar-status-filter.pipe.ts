import { Pipe, PipeTransform } from '@angular/core';
import { CalendarStatusEnum, ICalendarItem } from '../portal/teacher-portal/class-details/calendarview/interfaces/calendar-item.interface';

@Pipe({
  name: 'calendarStatusFilter'
})
export class CalendarStatusFilterPipe implements PipeTransform {

  transform(value:ICalendarItem[] , status : CalendarStatusEnum): ICalendarItem[] {
    return value.filter(item => item.status == status);
  }

}
