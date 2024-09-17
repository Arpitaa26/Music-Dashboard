import {
  AfterViewChecked,
  Component,
  DebugNode,
  ElementRef,
  EventEmitter,
  Input,
  OnInit,
  Output,
  ViewChild,
} from '@angular/core';
import { Router } from '@angular/router';
import { Reschedule } from 'src/app/basic-module/reschedule/interface/reschedule-interface';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import { HttpClient } from '@angular/common/http';
import { DomSanitizer, SafeHtml } from '@angular/platform-browser';
import { ActivatedRoute, Params } from '@angular/router';
import {
  ScheduleClassInterface,
  ScheduleStatusEnum,
} from 'src/app/portal/student-portal/class-details/scheduleclass/interface/scheduleclass-interface';
import { ScheduleclassModel } from 'src/app/portal/student-portal/class-details/scheduleclass/model/scheduleclass-model';
import { Chart, Colors, Legend, registerables } from 'node_modules/chart.js';
Chart.register(...registerables);
import {
  UserRescheduleGet,
  UserAvailableInterface,
} from 'src/app/portal/student-portal/class-details/scheduleclass/model/reschedule-interface';
import {
  BulletinEventInterface,
  EventsImage,
} from '../Interface/eventsInterface';
import { FormControl, FormGroup } from '@angular/forms';
import { DatePipe, formatDate } from '@angular/common';
import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'getScheduleByStatusTwo',
})
export class GetScheduleByStatusTwoPipe implements PipeTransform {
  transform(
    value: ScheduleClassInterface[],
    key: ScheduleStatusEnum
  ): ScheduleClassInterface[] {
    if (!value) {
      return [];
    }
    return value.filter((item) => (item.status = key));
  }
}

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss'],
})
export class DashboardComponent implements OnInit, AfterViewChecked {
  @ViewChild('scrollBottom') private scrollBottom!: ElementRef;
  /*put EventEmitter*/
  @Output() messageEvent = new EventEmitter<string>();
  users: number[] = [];
  isUserHave: boolean = false;
  isLoading: boolean = true;
  result: any;
  // instaData: any;
  UserAvailableInterface: null | undefined | UserAvailableInterface;
  BulletinEventInterface: null | undefined | BulletinEventInterface;
  UserRescheduleGet: undefined | null | UserRescheduleGet;
  imageObject: EventsImage[] = [];
  public currentDate: string | null = null;

  getData() {}
  @Input() rescheduleData: Reschedule[] = [];
  @Output() selectRadio = new EventEmitter<Reschedule>();
  @Output() reschedule_popup_close = new EventEmitter<boolean>();

  schedule_close = false;
  // scheduleList: ScheduleClassInterface[] = ScheduleclassModel.returnMethod;
  scheduleList: ScheduleClassInterface[] = [];
  scheduleStatus = ScheduleStatusEnum;
  loading: boolean = true;
  constructor(
    private userData: UserDataService,
    private http: HttpClient,
    private sanitizer: DomSanitizer,
    private router: ActivatedRoute,
    private routerPath: Router,
    private dateTransform: DatePipe
  ) {}

  todayNumber: number = Date.now();
  todayDate: Date = new Date();
  todayString: string = new Date().toDateString();
  todayISOString: string = new Date().toISOString();

  userform = new FormGroup({});

  // redirect(str: string) {
  //   this.router.navigate([str]);
  // }
  open_reschedule_popup(isReschedule: boolean) {
    if (!isReschedule) return;
    this.schedule_close = true;
  }
  schedule_pop_close(evt: boolean) {
    if (!evt) return;
    this.schedule_close = true;
  }
  close() {
    this.schedule_close = !this.schedule_close;
    // this.schedule_close = false;
  }
  schedule_open() {
    this.schedule_close = true;
  }
  teacher_gread: any = [];
  all_gd: any = [];
  urlbase: any;
  store_ids: any;
  start_timee: any;
  module_namee: any;
  started_status: any;
  reschedule_message: any;
  event_status: any;
  ngOnInit(): void {
    this.graph_chart();
    this.userData.users();

    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_BULLETIN_EVENT,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.BulletinEventInterface = result;
        this.urlbase = 'https://thesvpacademy.com/admin/file/open/';
        // console.log(this.BulletinEventInterface);
        console.log(this.BulletinEventInterface?.data);
        this.event_status = this.BulletinEventInterface?.data;
        console.log('-----------------------------------');
      });
    // event api

    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_BULLETIN_EVENT,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.BulletinEventInterface = result;
        this.urlbase = 'https://thesvpacademy.com/admin/file/open/';
        console.log(this.BulletinEventInterface);
        console.log(this.BulletinEventInterface?.data);
      });

    // schedule class
    const now = new Date();
    const nextWeek = new Date(now);
    let wrape_day = nextWeek.setDate(now.getDate() + 7);

    const year = nextWeek.getFullYear();
    const month = String(nextWeek.getMonth() + 1).padStart(2, '0'); // Month is 0-indexed
    const day = String(nextWeek.getDate()).padStart(2, '0');
    const hours = String(nextWeek.getHours()).padStart(2, '0');
    const minutes = String(nextWeek.getMinutes()).padStart(2, '0');
    const seconds = String(nextWeek.getSeconds()).padStart(2, '0');

    let formattedDate = `${year}-${month}-${day}`;

    // schedule class get all
    this.currentDate =
      this.router.snapshot.paramMap.get('date') != null
        ? this.router.snapshot.paramMap.get('date')
        : new Date().toJSON().slice(0, 10);

    console.log(this.currentDate);
    const currentDate = new Date();

    const sevenDaysLater = new Date(formattedDate);
    let store_date = sevenDaysLater.setDate(currentDate.getDate());

    this.userData
      .callApi(
        {
          from: this.currentDate + ' 00:00:00',
          to: formattedDate + ' 23:59:59',
        },
        VariableConstants.METHOD_GET,
        RequestMapper.API_CLASS_SCHEDULE_GET_ALL + '?order_by=ASC',
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.scheduleList = result?.data;
        this.loading = false;

        if (this.scheduleList.length === 1) {
          this.store_ids = this.scheduleList[0].id;
          this.module_namee = this.scheduleList[0].module_name;
          this.start_timee = this.scheduleList[0].start_time;
          this.started_status = this.scheduleList[0].status;
          let str: any = this.scheduleList[0].start_time;
          if (this.started_status == this.scheduleStatus.STARTED) {
            localStorage.setItem('ClassId', this.store_ids);
            localStorage.setItem('ModuleName', this.module_namee);
            localStorage.setItem('StartTime', this.start_timee);
          } else {
            console.log('class is not started');
          }
        }

        // Check status value in teacher
        // if (this.started_status == 'STARTED') {
        //   localStorage.setItem('ClassId', this.store_ids);
        //   localStorage.setItem('ModuleName', this.module_namee);
        //   localStorage.setItem('StartTime', this.start_timee);
        // } else {
        //   console.log('class is not started');
        // }

        let str: any = this.scheduleList[0].start_time;
        const date = new Date(str);
        this.rc_message(this.store_ids);
      });

    // API TO Call Insta Image ******************************
    // let token =
    //   'IGQWRQOGk5SFhsc3FIeVVSSjkyT1BCbXlLeWVPNHZAPX3QzUUFHc3o5ZA2VNU0xTVzlTWGdkdWVhTnpSRklvY2tGdmtaWkhNOUdzS2JqdXVPTXU2cjhmREpUOHZA0aW03N3NjZADF2ZAGRLVTgyZA0pvSkZAnRUttbGpodkkZD';
    // this.http
    //   .get<any>(
    //     'https://graph.instagram.com/me/media?fields=caption,id,media_type,media_url,permalink,thumbnail_url,timestamp,username&access_token=' +
    //       token
    //   )
    //   .subscribe((value) => {
    //     console.log(value);
    //     this.result = this.sanitizer.bypassSecurityTrustHtml(value.html);
    //     console.log(value.data);
    //     this.instaData = value.data;
    //     for (let data of this.instaData) {
    //       this.imageObject.push({
    //         image: data.media_url,
    //         thumbImage: data.media_url,
    //       });
    //     }
    //   });
    //   let propertyNames:any= []
    // let items = document.getElementsByClassName('fade-item');
    // for (let i = 0; i < items.length; ++i) {
    //   this.fadeIn(items[i], i * 400);
    // }

    //COOKIE AND CUTNIP
    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_TEACHER_COOKIE_CUTNIP,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.teacher_gread = result?.data;

        let all_greads = JSON.parse(this.teacher_gread.performance);
        console.log(all_greads);

        this.all_gd = JSON.parse(this.teacher_gread.performance);

        console.log(result);

        this.all_rd = this.all_gd.attendance_reschedule_cutnip;
        localStorage.setItem(
          'Total Reschedules',
          this.all_gd.attendance_reschedule_cutnip
        );
      });
    this.pie_chart();

    //  RESHEDULE MESSAGE

    localStorage.setItem(
      'Total Reschedules',
      this.all_gd.attendance_reschedule_cutnip
    );
  }
  all_rd: any;
  rc_message(data: any) {}
  redirectToSupport(item: ScheduleClassInterface) {
    this.routerPath.navigate([
      '/portal/teachers/support/task-create/',
      item.id,
      item.module_name,
      item.start_time,
    ]);
  }

  // ({id:item.id,link:item.link,class_status:item.status})
  // this.router.navigate(['portal/students/all_courses/courses_buys/',data.course_id,data.lavel,data.type])

  reschedules = localStorage.getItem('Total Reschedules');
  Salary = localStorage.getItem('Salary');
  currency = localStorage.getItem('Currency');

  graph_with_day: any[] = [];
  my_array: any;
  g_day: any;
  l_data: any;
  n_day: any;
  long_day: any;
  entriesArray_day: any;
  map_msg: any;
  // Only_api_section
  graph_chart() {
    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_GET_DAY_CLASS_ALL,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.graph_with_day = result.data;
        console.log((this.graph_with_day = result.data));
        console.log(typeof this.graph_with_day);
        let respData = JSON.parse(result.data);
        this.my_array = Object.values(respData);
        // debugger
        if (respData.users) {
          this.users = respData.users;
          this.isUserHave = this.users.some((el) => el > 0);
        }
        this.g_day = this.my_array[0];
        this.n_day = this.my_array[2];
        this.long_day = this.my_array[1];

        console.log(typeof this.g_day);

        let data_arr = [];
        for (const key in this.g_day) {
          if (this.g_day.hasOwnProperty(key)) {
            data_arr.push({ key: key, value: this.g_day[key] });
          }
        }
        let data_arr1 = [];
        let data_arr2 = [];
        for (const keys in this.n_day) {
          if (this.n_day.hasOwnProperty(keys)) {
            data_arr2.push({ key: keys, value: this.n_day[keys] });
          }
        }
        for (const keyw in this.long_day) {
          if (this.long_day.hasOwnProperty(keyw)) {
            data_arr1.push({ key: keyw, value: this.long_day[keyw] });
          }
        }
        //return data_arr;
        console.log(data_arr2);
        this.l_data = data_arr;
        this.b_data = data_arr2;

        console.log(this.b_data);
        this.on_data = data_arr1;
        this.bar_chart(this.my_array[0], this.my_array[2], this.my_array[1]);
      });
  }
  areAllElementsZero(): boolean {
    return this.map_msg.every(
      (element: any) => element === '0' || element === 0
    );
  }

  on_data: any;
  b_data: any;
  all_class_data: any = [];
  month: any;
  started: Number | undefined | any;
  not_started: Number | undefined | any;
  blank_arr: any = [];
  blank_start: any = [];
  blank_not_started: any = [];
  all_chart_data: any;
  status_rc: any;
  pie_chart() {
    // Only_api_section
    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_GET_MONTH_CLASS_ALL,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.all_class_data = result.data;

        let chart_data = JSON.parse(result.data);
        console.log(chart_data);
        this.all_chart_data = JSON.parse(result.data);
        console.log('***********************************');
        this.month = chart_data.months;
        this.started = parseInt(chart_data.started[0]);
        this.not_started = parseInt(chart_data.not_started[0]);

        this.blank_arr = [];
        for (const key in this.month) {
          console.log(key);
          if (this.month.hasOwnProperty(key)) {
            this.blank_arr.push({ key: key, value: this.month[key] });
          }
        }

        // console.log(this.started, this.not_started);
        // console.log(typeof this.not_started);

        console.log(typeof this.not_started);
        console.log(this.started, this.not_started);
        this.render_chart_js(this.blank_arr[0], this.started, this.not_started);
      });
    // Only_api_sectionEnd for graph
  }

  isArrayEmpty(): boolean {
    //this.all_class_data
    return this.all_class_data == '[]';
    // return (this.started.length === 1 && this.started === 0) && (this.not_started.length === 0);
  }

  dynamicCutoutPercentage: number = 60;
  render_chart_js(
    blank_arr: any,
    started: Number | undefined,
    not_started: Number | undefined
  ) {
    const LegendMarginRight = {
      id: 'legendMarginRight',
      afterInit(chart: any, legend: any, options: any) {
        console.log(chart.legend.fit);
        const fitValue = chart.legend.fit;
        chart.legend.fit = function fit() {
          fitValue.bind(chart.legend)();
          return (this.height += 30);
        };
      },
    };
    let cutoutPercentageValue = 70;
    new Chart('pie_chart', {
      type: 'doughnut',
      data: {
        datasets: [
          {
            label: blank_arr.value,
            data: [started, not_started],
            backgroundColor: ['#EE9C13', '#5E3A7D'],
            borderColor: ['#fff', '#fff', '#fff'],
            borderWidth: 0,
          },
        ],
        labels: ['Completed', 'Scheduled'],
      },
      options: {
        plugins: {
          legend: {
            position: 'bottom', // 'bottom', 'left', 'right' are also available
            align: 'start',
            labels: {
              padding: 30,
            },
          },
        },
        layout: {
          padding: {
            left: 0, // Adjust the left padding for labels
            right: 0, // Adjust the right padding for labels
            top: 0, // Adjust the top padding for labels
            bottom: 0, // Adjust the bottom padding for labels
          },
        },
        cutout: '65%',
        elements: {
          arc: {
            borderWidth: 1, // Set a slim border for the doughnut
            borderColor: '#fff', // Set border color to match background color
            borderAlign: 'inner',
            borderRadius: 0, // Set the border radius for rounded edges
          },
        },
      },
      plugins: [LegendMarginRight],
    });
  }

  bar_chart(entriesArray: any, long_day: any, y_aacess: any) {
    //this.entriesArray_day = Object.entries(entriesArray);

    console.log(entriesArray);
    console.log('##################################################');
    //  const originalDates = [new Date(), entriesArray];

    // // Format dates as "MMM DD YYYY"
    // const formattedDates = originalDates.map(date => {
    //   const options:any = { month: 'long', day: 'numeric', year: 'numeric' };
    //   return date.toLocaleDateString('en-US', options);
    // });
    const formantedDates = entriesArray.map((el: string) => {
      const [day, month, year] = el.split('-');
      return formatDate(new Date(+year, +month - 1, +day), 'dd-MM', 'en-US');
    });

    const config = new Chart('bar_charts', {
      type: 'bar',
      data: {
        labels: formantedDates,
        datasets: [
          {
            label: 'Class / Day',
            data: long_day,
            backgroundColor: [
              'rgba(231, 146, 0, 1)',
              'rgba(231, 146, 0, 1)',
              'rgba(231, 146, 0, 1)',
              'rgba(231, 146, 0, 1)',
              'rgba(231, 146, 0, 1)',
              'rgba(231, 146, 0, 1)',
              'rgba(231, 146, 0, 1)',
            ],
            borderColor: [
              'rgb(255,255,255)',
              'rgb(255,255,255)',
              'rgb(255,255,255)',
              'rgb(255,255,255)',
              'rgb(255,255,255)',
              'rgb(255,255,255)',
              'rgb(255,255,255)',
            ],

            borderRadius: 10,
            borderWidth: 0.5,
            barThickness: 8,
          },
        ],
      },
      options: {
        maintainAspectRatio: false,
        indexAxis: 'y',
        plugins: {
          legend: {
            display: false,
          },
        },
        scales: {
          y: {
            ticks: {
              color: '#fff',
              font: {
                size: 10,
              },
            },
            grid: {
              display: false,
            },
          },
          x: {
            min: 0,
            beginAtZero: true,
            ticks: {
              stepSize: 1,
              color: '#fff',
              font: {
                size: 15,
              },
            },
            grid: {
              color: '#5B5B5B',
            },
          },
        },
      },
    });
    this.isLoading = false;

    // let labels:any = Utils.months({count: 7});
  }

  users_number = localStorage.getItem('users_number');

  res: any = [];
  st_msg: any;
  staus_sucess: boolean = false;
  false_sucess: boolean = false;
  joinclass(uId: any) {
    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_POST,
        RequestMapper.API_ATTENDANCE_JOIN + uId.id,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.res = result;
        this.status_rc == this.res.status;
        setTimeout(() => {
          if (this.res.status == '200') {
            //  window.location.reload();
            window.open(uId.link);
            this.st_msg = this.res.body.message;
            this.staus_sucess = true;
            this.messageEvent.emit(this.st_msg);
          } else if (this.res.status == '203') {
            //console.log(this.res.status);
            this.false_sucess = true;
            this.st_msg = this.res.body.message;
            this.messageEvent.emit(this.st_msg);
          } else {
            this.false_sucess = true;
            this.st_msg = this.res.body.message;
            this.messageEvent.emit(this.st_msg);
          }

          setTimeout(() => {
            this.st_msg = '';
            this.staus_sucess = false;
            this.false_sucess = false;
            window.location.reload();
          }, 3000);
        }, 3000);

        if (uId.class_status == 'STARTED') {
          localStorage.setItem('ClassId', uId.id);
        } else {
        }
      });
  }
  user_ids: any;
  msg: any;
  rc_status: boolean = false;
  user_class_get(data: any) {
    localStorage.setItem('classId', data.classId);
    var today = this.dateTransform.transform(new Date(), 'yyyy-MM-dd');
    this.user_ids = localStorage.getItem('user_id');
    //  let data_field: any = {

    //   availability_id: data.availability_id,

    //   class_id: this.classId,
    // };
    this.userData
      .callApi(
        {
          availability_id: data.availability_id,
          class_id: data.classId,
        },
        VariableConstants.METHOD_POST,
        RequestMapper.API_RESCHEDULE_MESSAGE,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.reschedule_message = result;
        console.log(this.reschedule_message.body.data);
        //console.log(result.type)
        this.msg = this.reschedule_message.body.data;
      });

    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_USER_AVAILABILITY_GET_ALL +
          '?user_id=' +
          data.user_id +
          '&today=' +
          today +
          '&id=' +
          data.classId,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.UserAvailableInterface = result;

        console.log(this.UserAvailableInterface?.data);
        console.log(
          '==================================================================================='
        );
      });
  }

  fadeIn(item: any, delay: any) {
    setTimeout(() => {
      item.classList.add('fadein');
    }, delay);
  }
  msgs: any;
  classId: any;
  rc_false_status: boolean = false;
  class_rd_request_save(data: any) {
    let get_class_id = localStorage.getItem('classId');
    this.classId = get_class_id;
    //this.classId = this.scheduleList[0].id;
    let data_field: any = {
      reason_for_reschedule: data.reason_for_reschedule,
      availability_id: data.availability_id,
      start_time: data.start_time,
      class_id: this.classId,
    };

    this.userData
      .callApi(
        data_field,
        VariableConstants.METHOD_POST,
        RequestMapper.API_RESCHEDULE_REQUEST_SAVE,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        // console.log(result);
        this.msgs = result;
        setTimeout(() => {
          if (this.res.status == '200') {
            this.rc_status = true;
            this.all_msgs = this.res.body.message;
            this.messageEvent.emit(this.all_msgs);
            //  alert(this.res.body.message);
          } else {
            alert(this.res.body.message);
            this.all_msgs = this.res.body.message;
            this.rc_false_status = true;
            this.messageEvent.emit(this.all_msgs);
          }
          this.schedule_close = false;
          // <<<---using ()=> syntax
          //    this.msgs = result.message;
          // this.msg = result.message;
          setTimeout(() => {
            this.all_msgs = '';
            this.rc_status = false;
            this.rc_false_status = false;
            window.location.reload();
          }, 3000);
        }, 3000);

        this.res = result;
      });
  }
  all_msgs: any;
  reschedule_post(data: any) {
    console.log(data);
  }
  com_status: any;
  completed_message: any;
  user_complete(comdata: any) {
    // data={END:data}
    console.log(comdata);

    // let all={END:comdata.END}
    this.userData
      .callApi(
        comdata,
        VariableConstants.METHOD_POST,
        RequestMapper.API_COMPLETE_CLASS + comdata.id,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        console.log(result);

        // if(this.com_status=='200'){
        //   alert("Class is Comleted")
        //   //this.completed_message = "Class is Comleted";
        // }
        this.com_status = result.status;

        setTimeout(() => {
          if (this.com_status == '200') {
            this.rc_status = true;
            this.all_msgs = result.body.message;
            this.messageEvent.emit(this.all_msgs);
            //  alert(this.res.body.message);
          } else {
            // alert(this.res.body.message);
            this.all_msgs = result.body.message;
            this.rc_false_status = true;
            this.messageEvent.emit(this.all_msgs);
          }
          this.schedule_close = false;

          setTimeout(() => {
            this.all_msgs = '';
            this.rc_status = false;
            this.rc_false_status = false;
            window.location.reload();
          }, 3000);
        }, 3000);

        setTimeout(() => {
          //s window.location.reload();
        }, 5000);
        console.log('=========================Test-======================');
        // window.location.reload();
      });
  }

  chartData = [
    { label: 'D1', value: 100 },
    { label: 'D2', value: 142 },
    { label: 'D3', value: 57 },
    { label: 'D4', value: 30 },
    { label: 'D5', value: 140 },
    { label: 'D6', value: 220 },
    { label: 'D7', value: 120 },
  ];

  ngAfterViewChecked() {
    this.scrollToBottom();
  }

  scrollToBottom(): void {
    try {
      this.scrollBottom.nativeElement.scrollTop =
        this.scrollBottom.nativeElement.scrollHeight;
    } catch (err) {}
  }
}
