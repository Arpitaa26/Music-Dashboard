import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { UserAvailableInterface } from 'src/app/portal/student-portal/class-details/scheduleclass/model/reschedule-interface';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import { Reschedule, reschedule_get } from '../interface/reschedule-interface';
@Component({
  selector: 'app-reshedule',
  templateUrl: './reschedule.component.html',
  styleUrls: ['./reschedule.component.scss'],
})
export class RescheduleComponent implements OnInit {
  @Input() rescheduleData: Reschedule[] = [];
  @Output() selectRadio = new EventEmitter<Reschedule>();
  @Output() reschedule_popup_close = new EventEmitter<boolean>();
  constructor(private userData:UserDataService) {}
  // change_radio(obj: Reschedule) {
  //   // console.log(obj);
  //   this.selectRadio.emit(obj);
  // }
  close() {
    this.reschedule_popup_close.emit(false);
  }
  reschedule_get:null|undefined|reschedule_get;
  UserAvailableInterface:null|undefined|UserAvailableInterface;
  ngOnInit(): void {
    // console.log(this.rescheduleData)

    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_RESCHEDULE_REQUEST_GET_ALL,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        console.log(result);
      });


      
   
  }
  // change_radio(item:any){
  //   this.userData
  //   .callApi(
  //     {},
  //     VariableConstants.METHOD_GET,
  //     RequestMapper.API_USER_AVAILABILITY_GET_ALL,
  //     VariableConstants.ACCESS_PRIVATE
  //   )
  //   .subscribe((result: any) => {
  
  //     this.UserAvailableInterface=result;
  //     console.log(this.UserAvailableInterface?.data[0].id);
  //   });
  // }
  // this.userData
  //     .callApi(
  //       {},
  //       VariableConstants.METHOD_GET,
  //       RequestMapper.API_USER_AVAILABILITY_GET_ALL,
  //       VariableConstants.ACCESS_PRIVATE
  //     )
  //     .subscribe((result: any) => {
  //       console.log(result);
  //     });
}
