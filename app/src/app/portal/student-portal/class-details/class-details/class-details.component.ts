import { Component, OnInit } from '@angular/core';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import { ScheduleClassInterface } from '../scheduleclass/interface/scheduleclass-interface';
import { ScheduleclassModel } from '../scheduleclass/model/scheduleclass-model';

@Component({
  selector: 'app-class-details',
  templateUrl: './class-details.component.html',
  styleUrls: ['./class-details.component.scss']
})
export class ClassDetailsComponent implements OnInit {
  scheduleList: ScheduleClassInterface[] = ScheduleclassModel.returnMethod;

  constructor(private userData: UserDataService,) { }

  ngOnInit(): void {

    // this.userData
    // .callApi(
    //   {},
    //   VariableConstants.METHOD_GET,
    //   RequestMapper.API_CLASS_SCHEDULE_GET_ALL,
    //   VariableConstants.ACCESS_PRIVATE
    // )
    // .subscribe((result: any) => {
    //   this.scheduleList = result?.data;

    //   console.log(this.scheduleList);
    
    // });

    
  }

}
