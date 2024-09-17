import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { UserRescheduleGet } from 'src/app/portal/student-portal/class-details/scheduleclass/model/reschedule-interface';
import { ScheduleClassInterface } from 'src/app/portal/student-portal/class-details/scheduleclass/interface/scheduleclass-interface';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import { ScheduleclassModel } from 'src/app/portal/student-portal/class-details/scheduleclass/model/scheduleclass-model';
import { reschedule_approve } from '../reschedule-approve-interface';
@Component({
  selector: 'app-reschdule-approve',
  templateUrl: './reschdule-approve.component.html',
  styleUrls: ['./reschdule-approve.component.scss']
})
export class ReschduleApproveComponent{
constructor(private userData:UserDataService){

}

private teacherAvailability ={
  "Monday": [],
  "Tuesday": [],
  "Wednesday": [],
  "Thursday": [],
  "Friday": [],
  "Saturday": [],
  "Sunday": [],
}


// private array =[
//   {
//     Monday : [
//       {0:'6:30'},
//       {1:'6:30'},
//       {2:'6:30'},
//       {3:'6:30'},
//       {4:'6:30'},
//     ]
//   },
//   {
//     Tuesday:[]
//   }
// ]
 
  //UserRescheduleGet: undefined | null | UserRescheduleGet;

//   public currentDate: string | null = null;
//   schedule_close = false;
//   scheduleList: ScheduleClassInterface[] = ScheduleclassModel.returnMethod;
//   reschedule_approve: undefined|null|reschedule_approve;
// constructor(private userData: UserDataService,
//   private router: ActivatedRoute,){}
//   ngOnInit(): void {
//   this.userData.users();

// // schedule class get all

// this.currentDate =
//       this.router.snapshot.paramMap.get('date') != null
//         ? this.router.snapshot.paramMap.get('date')
//         : new Date().toJSON().slice(0, 10);

// console.log(this.currentDate);

// this.userData
//   .callApi(
//     {},
//     VariableConstants.METHOD_GET,
//     RequestMapper.API_CLASS_RESCHEDULE,
//     VariableConstants.ACCESS_PRIVATE
//   )
//   .subscribe((result: any) => {
//     this.reschedule_approve = result;

//     console.log(this.reschedule_approve?.data);
    
    
   
  
//   });
// }


// res:any=[];
// approve(uIds:any) {


//   this.userData
//     .callApi({},VariableConstants.METHOD_POST,
//       RequestMapper.API_RESCHEDULE_CLASS_APPROVED+uIds,
//       VariableConstants.ACCESS_PRIVATE)
//     .subscribe((result: any) => {
//       this.res=result;
//       console.log(this.res)
     
      
//     });
   
// }
all:any=[]
date_time:any=[]
ngOnInit(): void {
  let weekdata:any|string = [
      [
        {"Monday":["0","6.00","6.15","6.30","6.45","7.00","7.15","7.30"]}
      ],
      [
        {"Tuesday":["0","6.00","6.15","6.30","6.45","7.00","7.15","7.30"]}
      ],
      [
        {"Wednesday":["0","6.00","6.15","6.30","6.45","7.00","7.15","7.30"]}
        
      ],
      [
        {"Thursday":["0","6.00","6.15","6.30","6.45","7.00","7.15","7.30"]}
      ],
      [
        {"Friday":["0","6.00","6.15","6.30","6.45","7.00","7.15","7.30"]}
      ],
      [
        {"Saturday":["0","6.00","6.15","6.30","6.45","7.00","7.15","7.30"]}
      ], 
  ];


this.date_time = weekdata
  console.log(weekdata[0])

 

}
selectedtime: string = '';

usertime(data:any){
  
console.log(data)
  let all_data ={ 
    "Monday":[data.Mon_Day-6.00,data.Mon_Day-6.15,data.Mon_Day-6.30,data.Mon_Day-6.45,data.Mon_Day-7.00,data.Mon_Day-7.15,data.Mon_Day-7.30],
   "Tuesday":[data.Tuesday-6.00,data.Tuesday-6.15,data.Tuesday-6.30,data.Tuesday-6.45,data.Tuesday-7.00,data.Tuesday-7.15,data.Tuesday-7.30],
   "Wednesday":[data.Wednesday-6.00,data.Wednesday-6.15,data.Wednesday-6.30,data.Wednesday-6.45,data.Wednesdayy-7.00,data.Wednesday-7.15,data.Wednesday-7.30],
   "Thursday":[data.Thursday-6.00,data.Thursday-6.15,data.Thursday-6.30,data.Thursday-6.45,data.Thursday-7.00,data.Thursday-7.15,data.Thursday-7.30],
   "Friday":[data.Friday-6.00,data.Friday-6.15,data.Friday-6.30,data.Friday-6.45,data.Friday-7.00,data.Friday-7.15,data.Friday-7.30],
   "Saturday":[data.Saturday-6.00,data.Saturday-6.15,data.Saturday-6.30,data.Saturday-6.45,data.Saturday-7.00,data.Saturday-7.15,data.Saturday-7.30],
  //  "Sunday":[data.Friday-6.00,data.Friday-6.15,data.Friday-6.30,data.Friday-6.45,data.Friday-7.00,data.Friday-7.15,data.Friday-7.30]         
}

// let all_data = {
//   "Tuesday" :[(data.tuesday).toString()]
// }
  console.log(all_data)
  this.userData
      .callApi(all_data,VariableConstants.METHOD_POST,
        RequestMapper.API_TEACHER_AVAILABILITY,
        VariableConstants.ACCESS_PRIVATE)
      .subscribe((result: any) => {
      
        console.log(result)
       
        
      });
  }
}
