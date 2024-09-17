import {
  Component,
  OnInit,
  ChangeDetectionStrategy,
  ViewChild,
  TemplateRef,
  LOCALE_ID,
  ElementRef,
  AfterViewInit,
  ChangeDetectorRef,
} from '@angular/core';
import { formatDate } from '@angular/common';
import {
  startOfDay,
  endOfDay,
  subDays,
  addDays,
  endOfMonth,
  isSameDay,
  isSameMonth,
  addHours,
} from 'date-fns';
import { Subject } from 'rxjs';
import { map, tap } from 'rxjs/operators';
import {
  CalendarEvent,
  CalendarEventAction,
  CalendarEventTimesChangedEvent,
  CalendarView,
} from 'angular-calendar';
import { EventColor } from 'calendar-utils';
// import { CalenderInfoInterface } from '../interface/calenderInterface';
// import { CalenderInfoModel } from '../model/calenderModel';

import { ActivatedRoute, Router } from '@angular/router';
import { RequestMapper } from 'src/app/request-mapper';
import { VariableConstants } from 'src/app/variable-contants';
import { UserDataService } from 'src/app/services/user-data.service';
import { CalenderInfoInterface } from 'src/app/portal/student-portal/class-details/calenderview/interface/calenderInterface';
import { ScheduleClassInterface } from 'src/app/basic-module/reschedule/interface/dasboard_interface';
import { ScheduleclassModel } from 'src/app/portal/student-portal/class-details/scheduleclass/model/scheduleclass-model';
import parseJSON from 'date-fns/parseJSON/index';
import { schdeulelistss } from '../calenderview-interace';
import {
  CalendarStatusEnum,
  ICalendarItem,
  ICalendarResponse,
} from '../interfaces/calendar-item.interface';

const colors: Record<string, EventColor> = {
  red: {
    primary: '#EE9C13',
    secondary: '#EE9C13',
  },
  green: {
    primary: 'green',
    secondary: 'green',
  },
  purple:{
    primary: '#5e3a7d',
    secondary: '#5e3a7d',
   },
   golden:{
    primary: '#d63031',
    secondary: '#d63031',
   }
};
// NOT_STARTED- Golden dots
// RESCHEDULED- Red dots
// COMPLETED- Green dots
// PENDING - purple
@Component({
  selector: 'app-calendarview',
  templateUrl: './calendarview.component.html',
  styleUrls: ['./calendarview.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
  styles: [
    `
      h3 {
        margin: 0 0 10px;
      }

      pre {
        background-color: #f5f5f5;
        padding: 15px;
      }
    `,
  ],
})
export class CalendarviewComponent implements OnInit, AfterViewInit {
  calendarVal: any;
  public currentDate: string | null = null;

  // scheduleList: ScheduleClassInterface[] = ScheduleclassModel.returnMethod;
  ngAfterViewInit(): void {}
  constructor(
    private userData: UserDataService,
    private actRouter: ActivatedRoute,
    private cdr: ChangeDetectorRef,
    private router: Router
  ) {}

  // @ViewChild('modalContent', { static: true }) modalContent: TemplateRef<any>;
  @ViewChild('myDiv', { read: ElementRef }) myDiv!: ElementRef;

  triggerFalseClick() {
    let el: HTMLElement = this.myDiv.nativeElement;
    el.click();
  }

  view: CalendarView = CalendarView.Month;

  CalendarView = CalendarView;

  viewDate: Date = new Date();

  actions: CalendarEventAction[] = [];

  refresh = new Subject<void>();

  calenderInfoList: CalenderInfoInterface[] = []; //CalenderInfoModel.returnMethod;

  events: CalendarEvent[] = [];
  dayevents: CalendarEvent[] = [];
  activeDayIsOpen: boolean = false;
  emptyDayEvents(): void {
    this.allScheduleItems = [];
    this.dayevents = [];
    this.activeDayIsOpen = false;
  }
  todays: any = [];
  options: any;
  moduleGet: any;
  schdeulelistss: null | undefined | schdeulelistss;
  allScheduleItems: ICalendarItem[] = [];
  calendarStatus = CalendarStatusEnum;
  hasPopupOpened = false; // A flag to track if the popup has opened
  loading: boolean = false;

  dt: any;

  // dayClicked({ date, events }: { date: Date; events: CalendarEvent[] }): void {
  //   if (isSameMonth(date, this.viewDate)) {
  //     if (
  //       (isSameDay(this.viewDate, date) && this.activeDayIsOpen === true) ||
  //       events.length === 0
  //     ) {
  //       this.activeDayIsOpen = false;
  //     } else {
  //       this.activeDayIsOpen = true;
  //     }
  //     this.viewDate = date;
  //     // this.dayClickedPopup({date,events});
  //   }
  // }

  dayClicked({ date, events }: { date: Date; events: CalendarEvent[] }): void {
    if (isSameMonth(date, this.viewDate)) {
      this.viewDate = date;
      if (
        (isSameDay(this.viewDate, date) && this.activeDayIsOpen === true) ||
        events.length === 0
      ) {
        this.activeDayIsOpen = false;
      } else {
        this.activeDayIsOpen = true;
        // this.dayClickedPopup({ date, events });
      }
    }
  }

  dayClickedPopup({
    date,
    events,
  }: {
    date: Date;
    events: CalendarEvent[];
  }): void {
    this.loading = true;
    this.todays = date;

    this.currentDate =
      this.actRouter.snapshot.paramMap.get(this.todays) != null
        ? this.actRouter.snapshot.paramMap.get(this.todays)
        : new Date().toJSON().slice(0, 10);

    const year = date.getFullYear(); // Get the current year
    const month = date.getMonth() + 1; // Get the current month (0-11, so we add 1)
    const day = date.getDate();
    const formattedDate = `${year}-${month.toString().padStart(2, '0')}-${day
      .toString()
      .padStart(2, '0')}`;

    console.log(formattedDate);

    this.userData
      .callApi(
        {
          from: formattedDate + ' 00:00:00',
          to: formattedDate + ' 23:59:59',
        },
        VariableConstants.METHOD_GET,
        RequestMapper.API_CLASS_SCHEDULE_GET_ALL +
          '?from=' +
          formattedDate +
          '00:00:00&to=' +
          formattedDate +
          '23:59:59',
        VariableConstants.ACCESS_PRIVATE
      )
      .pipe(
        tap((result: ICalendarResponse) => {
          this.allScheduleItems = result.data;
          this.dt = this.allScheduleItems;
          this.dayevents = this.events;
          this.hasPopupOpened = true;
          this.loading = false;
          this.cdr.markForCheck();
        })
      )
      .subscribe();
    // setTimeout(() => {
    //   this.dayevents = this.events;
    // }, 500);
    console.log(this.todays);
  }

  eventTimesChanged({
    event,
    newStart,
    newEnd,
  }: CalendarEventTimesChangedEvent): void {
    this.events = this.events.map((iEvent) => {
      if (iEvent === event) {
        return {
          ...event,
          start: newStart,
          end: newEnd,
        };
      }
      return iEvent;
    });
    this.handleEvent('Dropped or resized', event);
  }

  handleEvent(action: string, event: CalendarEvent): void {
    // this.modalData = { event, action };
    // this.modal.open(this.modalContent, { size: 'lg' });
    // alert(action);]
    // console.log(action);
    // console.log(event.start);
    let startDate = new Date(event.start)
      .toLocaleDateString()
      .replace(/\//g, '-');
    let newDate = formatDate(startDate, 'yyyy-MM-dd', 'en-US');
    // console.log(newDate);
    // this.actRouter.navigate([
    //   'portal/students/class_details/schedule_class/',
    //   newDate,
    // ]);
    // console.log('hello World');
    
  }

  addEvent(): void {
    this.events = [
      ...this.events,
      {
        title: 'New event',

        start: startOfDay(new Date()),
        end: endOfDay(new Date()),
        color: colors['red'], 
        
        draggable: true,
        resizable: {
          beforeStart: true,
          afterEnd: true,
        },
      },
    ];
  }

  deleteEvent(eventToDelete: CalendarEvent) {
    this.events = this.events.filter((event) => event !== eventToDelete);
  }

  setView(view: CalendarView) {
    this.view = view;
  }

  closeOpenMonthViewDay() {
    this.activeDayIsOpen = false;
  }
  date_time: any;
  students: any;
  color:any;
  ngOnInit(): void {
    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_CALENDAR,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        // console.log(result.data);
        this.calendarVal = result.data;
        this.events = [];
        let viewDate: Date;
        this.events = this.calendarVal.map((book: any) => {
          this.date_time = formatDate(
            new Date(book.start_time),
            'h:mm a',
            'en-US'
          );
          console.log(book.start_time);
          console.log("-----------------------------------------------------")
          console.log(book.status);
          const title =
            `<div>` +
            book.course_name +
            `</div><div>` +
            this.date_time ;
           
            // `</div><div>` +
            // book.batch_code +
            // `</div>`;
            if (book.status === 'NOT_STARTED') {
               this.color = { ...colors['red'] };
            } else if(book.status === 'PENDING') {
                this.color = { ...colors['purple'] };
            }else if(book.status==='RESCHEDULED'){
              this.color = {...colors['golden']}
            }else if(book.status==='COMPLETED'){
              this.color = {...colors['green']}
            }else{
              this.color = { ...colors['green'] };
            }
          return {
            // start: new Date(book.start_time), // use the book (current element in the iteration) directly here
            // viewDate:startOfDay(new Date(book.start_time)),
            // end: endOfDay(new Date(book.end_time)),
            end: new Date(book.end_time),
            title,
            start: new Date(book.start_time),
            color:this.color,
            //  start: startOfDay(new Date(book.start_time)),
            // startDate:book.start_time,
            // endDate:book.end_time,
            // color:
            //   book.status == 'NOT_STARTED'
            //     ? { ...colors['red'] }
            //     : { ...colors['green'] },
                
            // colors:
            //     book.status == 'PENDING'
            //     ? { ...colors['purple'] }
            //     : { ...colors['purple'] },

               // color: book.status === 'NOT_STARTED' ? { ...colors['red'] } : { ...colors['green'] },
               // color: book.status === 'PENDING' ? { ...colors['purple'] } : { ...colors['other_color'] },
            // color:
            //   book.status==''
            
            actions: this.actions,
            resizable: {
              beforeStart: true,
              afterEnd: true,
            },
            draggable: false,
          };
        });
        console.log(this.events);

        console.log('====================================================');
        this.triggerFalseClick();
        this.cdr.markForCheck();
        // this.refresh = new Subject<void>();
        // this.handleEvent('Dropped or resized', event);
      });
    this.evt = this.cald?.event;

    this.handleEvent('Dropped or resized', this.evt);

    // Api all classes

    // if (!VariableConstants.IS_LOCAL) {
    //   this.userData
    //     .callApi(
    //       {
    //         from: this.currentDate + ' 00:00:00',
    //         to: this.currentDate + ' 23:59:59',
    //       },
    //       VariableConstants.METHOD_GET,
    //       RequestMapper.API_CLASS_SCHEDULE_GET_ALL,
    //       VariableConstants.ACCESS_PRIVATE
    //     )
    //     .subscribe((result: any) => {
    //       this.scheduleList = result?.data;
    //       new Date();

    //       console.log(result.message);
    //     });
    //   }

    // api all classes end
  }
  cald: null | undefined | CalendarEventTimesChangedEvent;
  evt: any;

  redirectToSupport(item: ICalendarItem) {
    this.router.navigate([
      '/portal/teachers/support/task-create/',
      item.id,
      item.module_name,
      item.start_time,
    ]);
  }

  redirectToDashboard() {
    this.router.navigate(['/portal/teachers/dashboard']);
  }
}
