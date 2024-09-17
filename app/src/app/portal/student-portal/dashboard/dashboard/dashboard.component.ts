import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { Router } from '@angular/router';
import { Reschedule } from 'src/app/basic-module/reschedule/interface/reschedule-interface';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import { ScheduleClassInterface, ScheduleStatusEnum } from '../../class-details/scheduleclass/interface/scheduleclass-interface';
import { Chart, registerables } from 'node_modules/chart.js';
Chart.register(...registerables);
import {
  RescheduleModel,
  UserAvailableInterface,
  UserRescheduleGet,
} from '../../class-details/scheduleclass/model/reschedule-interface';
import { ScheduleclassModel } from '../../class-details/scheduleclass/model/scheduleclass-model';
import { HttpClient } from '@angular/common/http';
import { DomSanitizer, SafeHtml } from '@angular/platform-browser';
import { ActivatedRoute, Params } from '@angular/router';
import {
  BulletinEventInterface,
  EventsImage,
} from '../interface/eventsInterface';
import { DatePipe } from '@angular/common';
import { uid } from 'chart.js/dist/helpers/helpers.core';
import { Pipe, PipeTransform } from '@angular/core';
@Pipe({
  name: 'getScheduleByStatus'
})
export class GetScheduleByStatusPipe implements PipeTransform {
  transform(value: ScheduleClassInterface[], key: ScheduleStatusEnum):ScheduleClassInterface[] {
    if(!value){
      return []
    }
    return value.filter(item => item.status = key)
    
  }

}
@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss'],
})
export class dashboardComponent implements OnInit {
  @Output() messageEvent = new EventEmitter<string>();
  users: any;
  result: any;
  instaData: any;
  store_ids: any;
  start_timee: any;
  module_namee: any;
  started_status!: ScheduleStatusEnum;
  UserAvailableInterface: null | undefined | UserAvailableInterface;
  UserRescheduleGet: undefined | null | UserRescheduleGet;
  BulletinEventInterface: null | undefined | BulletinEventInterface;
  urlbase: any;
  event_status:any;
  public currentDate: string | null = null;

  imageObject: EventsImage[] = [];
  level_graphs: any[] = [];

  getData() {}
  @Input() rescheduleData: Reschedule[] = [];
  @Output() selectRadio = new EventEmitter<Reschedule>();
  @Output() reschedule_popup_close = new EventEmitter<boolean>();

  schedule_close = false;
  scheduleList: ScheduleClassInterface[] = ScheduleclassModel.returnMethod;
  scheduleStatus = ScheduleStatusEnum;
  isLoading:boolean = true
  constructor(
    private router: ActivatedRoute,
    private routerPath: Router,
    private userData: UserDataService,
    private http: HttpClient,
    private sanitizer: DomSanitizer,
    private dateTransform: DatePipe,
  ) {}
  

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
  class_lavel: any;
  used: any;
  dash_board_status:any;
  renew_status:any;
  wrap_data:any;
  used_class:any;
  ngOnInit(): void {
    this.userData.users();
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
    let store_date = sevenDaysLater.setDate(currentDate.getDate() + 7);

    // console.log(store_date)
    // console.log("7 Days Later:", sevenDaysLater.toDateString());
    this.userData
      .callApi(
        {
          from: this.currentDate + ' 00:00:00',
          to: formattedDate,
        },
        VariableConstants.METHOD_GET,
        RequestMapper.API_CLASS_SCHEDULE_GET_ALL + '?order_by=ASC',
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.dash_board_status = result?.data;
        this.scheduleList = (result?.data || []);

        console.log("-----------------------------")
        console.log(this.scheduleList);
        debugger
        this.isLoading = false
        if (this.scheduleList.length === 1) {
          this.store_ids = this.scheduleList[0].id;
          this.module_namee = this.scheduleList[0].module_name;
          this.start_timee = this.scheduleList[0].start_time;
          this.started_status = this.scheduleList[0].status;
          let str: any = this.scheduleList[0].start_time;
          if (this.started_status == this.scheduleStatus.NOT_STARTED) {
            localStorage.setItem('ClassId', this.store_ids);
            localStorage.setItem('ModuleName', this.module_namee);
            localStorage.setItem('StartTime', this.start_timee);
          } else {
            console.log('class is not started');
          }
        }

        // if (this.scheduleList) {
        //   for (let i = 0; i < this.scheduleList.length; i++) {
        //     console.log(this.scheduleList[i].user_id);
        //     //console.log(this.scheduleList);
        //     localStorage.setItem('cid', `${this.scheduleList[i].id}`);
        //     localStorage.setItem(
        //       'batch_id',
        //       `${this.scheduleList[i].batch_id}`
        //     );
        //     localStorage.setItem('status', `${this.scheduleList[i].status}`);
        //     localStorage.setItem('users_number', `${this.scheduleList[i].user_id}`);
        //     localStorage.setItem(
        //       'batch_code',
        //       `${this.scheduleList[i].batch_code}`
        //     );
        //     localStorage.setItem(
        //       'session_id',
        //       `${this.scheduleList[i].session_id}`
        //     );
        //     localStorage.setItem(
        //       'start_time',
        //       `${this.scheduleList[i].start_time}`
        //     );
        //     localStorage.setItem(
        //       'end_time',
        //       `${this.scheduleList[i].end_time}`
        //     );
        //     localStorage.setItem(
        //       'description',
        //       `${this.scheduleList[i].description}`
        //     );
        //     localStorage.setItem('link', `${this.scheduleList[i].link}`);
        //     localStorage.setItem(
        //       'recorded_link',
        //       `${this.scheduleList[i].recorded_link}`
        //     );
        //     localStorage.setItem('level', `${this.scheduleList[i].level}`);
        //     localStorage.setItem(
        //       'module_id',
        //       `${this.scheduleList[i].module_id}`
        //     );
        //   }
        // }
      });

    // this.userData
    //   .callApi(
    //     {},
    //     VariableConstants.METHOD_GET,
    //     RequestMapper.API_USER_AVAILABILITY_GET_ALL,
    //     VariableConstants.ACCESS_PRIVATE
    //   )
    //   .subscribe((result: any) => {
    //     this.UserAvailableInterface = result;
    //     console.log(this.UserAvailableInterface);
    //   });

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
    //       if (data.media_type == 'IMAGE') {
    //         this.imageObject.push({
    //           image: data.media_url,
    //           thumbImage: data.media_url,
    //           mediaType: data.media_type,
    //         });
    //       } else if (data.media_type == 'VIDEO') {
    //         this.imageObject.push({
    //           image: data.thumbnail_url,
    //           thumbImage: data.thumbnail_url,
    //           mediaType: data.media_type,
    //         });
    //       }
    //     }
    //   });

    let user_id = localStorage.getItem('user_id');

    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_CLASS_RENEWAL ,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        console.log(result);
        console.log("----------------------------------------------used_class")
        this.renew_status = result.code;
        this.level_graphs = result.data || [];
        console.log(this.level_graphs)
  
        if (this.level_graphs.length === 1) {
          this.wrap_data = this.level_graphs[0];

          localStorage.setItem('graph_count', this.wrap_data.class_purchased);
          localStorage.setItem('class_used', this.wrap_data.class_used);
          let total_class =
            ((this.wrap_data.class_purchased - this.wrap_data.class_used) /
            this.wrap_data.class_purchased) *
            100;

          let clt = total_class / this.wrap_data.class_purchased;
          console.log(clt);
          this.class_lavel = Array.from(
            { length: this.wrap_data.class_purchased },
            (_, index) => ({
              width: clt * (index + 1),
              isInactive: index === this.wrap_data.class_used,
            })
          );

          // this.bar_pai_chart(wrap_data.class_purchased,wrap_data.class_used);   wrap_data.class_used
          this.bar_pai_chart(total_class);
        }

        // ((Total class - completed class )/Total Class ) * 100
      });

    //  event api

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
        this.event_status=this.BulletinEventInterface?.data;
      });
  }

  alg = localStorage.getItem('graph_count');
  itemCount: any = localStorage.getItem('graph_count'); // Replace with your actual count
  // algclass_used = localStorage.getItem('class_used')
  itemCount_class_used: any = localStorage.getItem('class_used'); // Replace with your actual count
  total_class = this.itemCount - this.itemCount_class_used;
  get boxArray(): any[] {
    return Array.from({ length: this.total_class / 10 }, (_, index) => index);
  }
  get class_used_boxArray(): any[] {
    return Array.from(
      { length: this.itemCount_class_used / 10 },
      (_, indexss) => indexss
    );
  }

  redirectToSupport(item: ScheduleClassInterface) {
    this.routerPath.navigate([
      '/portal/teachers/support/task-create/',
      item.id,
      item.module_name,
      item.start_time,
    ]);
  }
  bar_pai_chart(p_class: any) {
    const myChart = new Chart('pie_chart', {
      type: 'line',
      data: {
        labels: ['Classes Left', 'Completed'],

        datasets: [
          {
            label: '',
            data: [p_class],
            backgroundColor: ['#EE9C13', '#5E3A7D'],
            borderColor: ['#fff', '#fff', '#fff'],
            borderWidth: 1,
          },
        ],
      },
      options: {
        scales: {
          y: {
            stacked: true,
          },
        },
      },
    });
    // const data =
  }

  // join class api

  // cid = localStorage.getItem('cid');
  // batch_id = localStorage.getItem('batch_id');
  // user_ids = localStorage.getItem('user_id');
  // status = localStorage.getItem('status');
  // batch_code = localStorage.getItem('batch_code');
  // session_id = localStorage.getItem('session_id');
  // start_time = localStorage.getItem('start_time');
  // end_time = localStorage.getItem('end_time');
  // description = localStorage.getItem('description');
  // link = localStorage.getItem('link');
  // recorded_link = localStorage.getItem('recorded_link');
  // level = localStorage.getItem('level');
  module_id = localStorage.getItem('module_id');
  users_number = localStorage.getItem('users_number');

  // jdata:any = {
  //   batch_id: this.batch_id,
  //   session_id: this.session_id,
  //   module_id: this.module_id,
  //   user_id: this.user_ids,
  //   status: this.status,
  //   start_time: this.start_time,
  //   end_time: this.end_time,
  //   description: this.description,
  //   link: this.link,
  //   recorded_link: this.recorded_link,
  //   level: this.level,

  // };
  res: any = [];
  st_msg:any;
  status_rc:any;
  staus_sucess:boolean=false;
 false_sucess:boolean=false;
  joinclass(uId: any) {
    // console.log(uId.link)
    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_POST,
        RequestMapper.API_ATTENDANCE_JOIN + uId.id,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.res = result;
        console.log(this.res);
        this.status_rc ==this.res.status ;
        setTimeout(() => {
         
          if (this.res.status == '200') {
           // 
          window.open(uId.link);
            this.st_msg = this.res.body.message;
            this.staus_sucess=true;
            this.messageEvent.emit(this.st_msg);
          } else if (this.res.status == '203') {
            //console.log(this.res.status);
            this.false_sucess=true;
  this.st_msg = this.res.body.message;
  this.messageEvent.emit(this.st_msg);
          } else {
            this.false_sucess=true;
            this.st_msg = this.res.body.message;
            this.messageEvent.emit(this.st_msg);
            window.location.reload();
          }



          setTimeout(() => {
            this.st_msg = ''; 
            this.staus_sucess=false;
            this.false_sucess=false;
            window.location.reload();
        }, 3000);
        }, 3000);



        // if (this.res.status == '200') {
        //   window.open(uId.link);
        // } else if (this.res.status == '203') {
         
        //   alert(this.res.body.message);
        // } else {
        //   alert(this.res.body.message);
        // }
      });
  }

  change_radio(item: any) {
    console.log(item);

    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_RESCHEDULE_REQUEST_GET + item,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.UserRescheduleGet = result;
        //console.log(this.UserRescheduleGet?.data.id);
        // localStorage.setItem('id', `${this.UserRescheduleGet?.id}`);
        // localStorage.setItem('user_id', `${this.UserRescheduleGet?.user_id}`);
        // localStorage.setItem('class_id', `${this.UserRescheduleGet?.class_id}`);
        // localStorage.setItem(
        //   'reason_for_reschedule',
        //   `${this.UserRescheduleGet?.reason_for_reschedule}`
        // );
      });
  }

  clId = localStorage.getItem('class_id');
  leave = localStorage.getItem('reason_for_reschedule');
  data = {
    class_id: this.clId,
    reason_for_reschedule: this.leave,
  };
  classId: any;
  msg: any = '';
  msgs: any;
  rc_status:boolean = false;
  rc_false_status:boolean =false;
  all_msgs: any;
  class_rd_request_save(data: any) {
    let get_class_id = localStorage.getItem('classId');
    this.classId = get_class_id;
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
        // setTimeout(() => {
        //   this.msg = result.body.message;
        // }, 1000);

        setTimeout(() => {
          if (result.body.code == '200') {
            this.rc_status=true;
            this.all_msgs = result.body.message;
            this.messageEvent.emit(this.all_msgs);
          //  alert(this.res.body.message);
            
          } else {
            // alert(result.body.message);
            this.all_msgs = result.body.message;
            this.rc_false_status = true;
            this.messageEvent.emit(this.all_msgs);
          }
          this.schedule_close = false;
          // <<<---using ()=> syntax
          //    this.msgs = result.message;
          // this.msg = result.message;
          setTimeout(() => {
            this.all_msgs = ''; 
           this.rc_status=false;
           this.rc_false_status = false;
            window.location.reload();
        }, 3000);
        }, 3000);



        this.schedule_close = false;
        localStorage.removeItem('classId');
        //this.schedule_close = !this.schedule_close;
      });
  }

  reschedule_post(data: any) {
    console.log(data);
  }
  user_id = localStorage.getItem('user_id');

  //   user_class_get() {
  //     // user availability  get all api
  //
  //     this.userData
  //       .callApi(
  //         {},
  //         VariableConstants.METHOD_GET,
  //         RequestMapper.API_USER_AVAILABILITY_GET_ALL +
  //           '?user_id='+this.users_number,
  //         VariableConstants.ACCESS_PRIVATE
  //       )
  //       .subscribe((result: any) => {
  //         this.UserAvailableInterface = result;
  //         console.log(result)
  //
  //         console.log(this.UserAvailableInterface?.data);
  //       });

  //     // end
  //   }
  user_ids: any;

  reschedule_message: any;
  user_class_get(data: any) {
    localStorage.setItem('classId', data.classId);

    var today = this.dateTransform.transform(new Date(), 'yyyy-MM-dd');
    this.userData
      .callApi(
        {
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
        this.msgs = this.reschedule_message.body.data;
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
  onEnrollClick(data :any):void{
    this.routerPath.navigate([
      'portal/students/course_info/all-courses',
      data.course_id,
      data.course_level_id,
      data.session_type_id,
    ]);
  }
  redirectToCourses(data: any) {
    this.routerPath.navigate([
      '/portal/students/course_info/all-courses'
    ]);
  }
}
function class_rc_request_save(data: any, any: any) {
  throw new Error('Function not implemented.');
}
