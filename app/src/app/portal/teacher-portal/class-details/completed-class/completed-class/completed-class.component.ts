import { Component } from '@angular/core';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import { ScheduleClassInterface } from './completed-class-interface';

@Component({
  selector: 'app-completed-class',
  templateUrl: './completed-class.component.html',
  styleUrls: ['./completed-class.component.scss']
})
export class CompletedClassComponent {

 constructor(private userData:UserDataService){}
  scheduleList: undefined | null | ScheduleClassInterface;

  ngOnInit(): void {

    
   
      this.userData
        .callApi(
          {
           
          },
          VariableConstants.METHOD_GET,
          RequestMapper.API_CLASS_SCHEDULE_GET_ALL+"?status=completed",
          VariableConstants.ACCESS_PRIVATE
        )
        .subscribe((result: any) => {

          this.scheduleList = result;
       
          console.log(this.scheduleList?.data);
         
        });
  
    }



}
