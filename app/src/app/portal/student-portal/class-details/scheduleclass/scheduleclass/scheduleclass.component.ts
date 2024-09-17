import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import {
  RescheduleModel,
  UserAvailableInterface,
  UserRescheduleGet,
} from '../model/reschedule-interface';
import { ScheduleclassModel } from '../model/scheduleclass-model';
import { Reschedule } from 'src/app/basic-module/reschedule/interface/reschedule-interface';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import { RequestMapper } from 'src/app/request-mapper';
import { ScheduleClassInterface } from '../interface/scheduleclass-interface';
import { DatePipe } from '@angular/common';
import { ActivatedRoute, Params } from '@angular/router';

@Component({
  selector: 'app-scheduleclass',
  templateUrl: './scheduleclass.component.html',
  styleUrls: ['./scheduleclass.component.scss'],
  providers: [DatePipe],
})
export class ScheduleclassComponent implements OnInit {
  users: any;
  public currentDate: string | null = null;
  i: any;

  constructor(
    private userData: UserDataService,
    private datePipe: DatePipe,
    private router: ActivatedRoute
  ) {
    // let day = this.myDate.getDate();
    // let month = this.myDate.getMonth()+1;
    // let year = this.myDate.getFullYear();
    // let allDate = this.datePipe.transform(this.myDate, `${day}-${month}-${year}`);
    // this.getData();
  }
  todayNumber: number = Date.now();
  todayDate: Date = new Date();
  todayString: string = new Date().toDateString();
  todayISOString: string = new Date().toISOString();
  today:any
  getData() {}
  @Input() rescheduleData: Reschedule[] = [];
  @Output() selectRadio = new EventEmitter<Reschedule>();
  @Output() reschedule_popup_close = new EventEmitter<boolean>();

  // change_radio(obj: Reschedule) {
  //   // console.log(obj);
  //   this.selectRadio.emit(obj);
  // }

  schedule_close = false;
  scheduleList: ScheduleClassInterface[] = ScheduleclassModel.returnMethod;
  temp_reschedule_arr = RescheduleModel.returnMethod;
  UserRescheduleGet: undefined | null | UserRescheduleGet;
  // change_radio(item: Reschedule) {
  //   console.log(item);
  //   // TODO: api call for reschedule radio
  // }
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
        console.log(this.UserRescheduleGet);
  
        localStorage.setItem('id', `${this.UserRescheduleGet?.id}`);
        localStorage.setItem('class_id', `${this.UserRescheduleGet?.class_id}`);
        localStorage.setItem(
          'reason_for_reschedule',
          `${this.UserRescheduleGet?.reason_for_reschedule}`
        );
      });

    // ('api_key', `${localStorage.getItem('token')}`);
  }
  clId = localStorage.getItem('cl-id');
  leave = localStorage.getItem('reason_for_reschedule');
  user_id = localStorage.getItem('user_id');
  data = {
    class_id: this.clId,
    reason_for_reschedule: 'Test',
    start_time: '2023-04-22 02:41:00',
    end_time: '2024-05-22 03:41:00',
  };
  classId:any;
  class_rd_request_save(data: any) {
    this.classId = this.scheduleList[0].id;
    let data_field:any = {reason_for_reschedule: data.reason_for_reschedule, availability_id: data.availability_id, start_time: data.start_time,class_id:this.classId}

  
    this.userData
      .callApi(
        data_field,
        VariableConstants.METHOD_POST,
        RequestMapper.API_RESCHEDULE_REQUEST_SAVE,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        // console.log(result);
      });
  }

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
  schedule_open(){
    this.schedule_close = true;
  }



  //=================================API_USER_AVAILABILITY================================
 
user_class_get(ids:any) {

  this.userData
    .callApi(
      {},
      VariableConstants.METHOD_GET,
      RequestMapper.API_USER_AVAILABILITY_GET_ALL +
        '?user_id='+ids,
      VariableConstants.ACCESS_PRIVATE
    )
    .subscribe((result: any) => {
      this.UserAvailableInterface = result;
      
     

      console.log(this.UserAvailableInterface?.data);
   
    });
}
  // scheduleList: undefined | null | ScheduleClassInterface;
  UserAvailableInterface: null | undefined | UserAvailableInterface;
 
  ngOnInit(): void {
    this.rescheduleData = this.temp_reschedule_arr;
    this.currentDate =
      this.router.snapshot.paramMap.get('date') != null
        ? this.router.snapshot.paramMap.get('date')
        : new Date().toJSON().slice(0, 10);

    console.log(this.currentDate);
    if (!VariableConstants.IS_LOCAL) {
      this.userData
        .callApi(
          {
            from: this.currentDate + ' 00:00:00',
            to: this.currentDate + ' 23:59:59',
          },
          VariableConstants.METHOD_GET,
          RequestMapper.API_CLASS_SCHEDULE_GET_ALL,
          VariableConstants.ACCESS_PRIVATE
        )
        .subscribe((result: any) => {
          this.scheduleList = result?.data;
          this.today = new Date().setHours(0,0,0,0); 
          new Date();
         
          console.log(result.message);
          if (this.scheduleList) {
            for (let i = 0; i < this.scheduleList.length; i++) {
              //console.log(this.scheduleList);
              localStorage.setItem('cid', `${this.scheduleList[i].id}`);
              localStorage.setItem(
                'batch_id',
                `${this.scheduleList[i].batch_id}`
              );
              localStorage.setItem('status', `${this.scheduleList[i].status}`);
              localStorage.setItem(
                'batch_code',
                `${this.scheduleList[i].batch_code}`
              );
              localStorage.setItem(
                'session_id',
                `${this.scheduleList[i].session_id}`
              );
              localStorage.setItem(
                'start_time',
                `${this.scheduleList[i].start_time}`
              );
              localStorage.setItem(
                'end_time',
                `${this.scheduleList[i].end_time}`
              );
              localStorage.setItem(
                'description',
                `${this.scheduleList[i].description}`
              );
              localStorage.setItem('link', `${this.scheduleList[i].link}`);
              localStorage.setItem(
                'recorded_link',
                `${this.scheduleList[i].recorded_link}`
              );
              localStorage.setItem('level', `${this.scheduleList[i].level}`);
              localStorage.setItem(
                'module_id',
                `${this.scheduleList[i].module_id}`
              );
            }
          }
        });

      // this.userData.schedule_class();
    }
  }
  cid = localStorage.getItem('cid');
  batch_id = localStorage.getItem('batch_id');
  user_ids = localStorage.getItem('user_id');
  status = localStorage.getItem('status');
  batch_code = localStorage.getItem('batch_code');
  session_id = localStorage.getItem('session_id');
  start_time = localStorage.getItem('start_time');
  end_time = localStorage.getItem('end_time');
  description = localStorage.getItem('description');
  link = localStorage.getItem('link');
  recorded_link = localStorage.getItem('recorded_link');
  level = localStorage.getItem('level');
  module_id = localStorage.getItem('module_id');
  
  jdata = {
    batch_id: this.batch_id,
    session_id: this.session_id,
    module_id: this.module_id,
    user_id: this.user_ids,
    status: this.status,
    start_time: this.start_time,
    end_time: this.end_time,
    description: this.description,
    link: this.link,
    recorded_link: this.recorded_link,
    level: this.level,
  };
  res:any=[];
  joinclass(uId:any) {
  
  
    this.userData
      .callApi({},VariableConstants.METHOD_POST,
        RequestMapper.API_ATTENDANCE_JOIN + uId.id,
        VariableConstants.ACCESS_PRIVATE)
      .subscribe((result: any) => {
        this.res=result;
        if(this.res.status=='200'){
          window.open(uId.link);
        }else if(this.res.status=='203'){
          //console.log(this.res.status);
          alert(this.res.body.message);
        }else{
          alert(this.res.body.message);
        }
      
        
      });
     
  }

  reschedule_post(data: any) {
    console.log(data);
  }
}
