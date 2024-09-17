import { Component } from '@angular/core';
import {
  FormArray,
  FormBuilder,
  FormControl,
  FormGroup,
  Validators,
} from '@angular/forms';
import { isObservable } from 'rxjs';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';

@Component({
  selector: 'app-teacher-availability',
  templateUrl: './teacher-availability.component.html',
  styleUrls: ['./teacher-availability.component.scss'],
})
export class TeacherAvailabilityComponent {
  checkBoxform: FormGroup;
  public isChecked: any;
  public availData: any;
  public avaliList: any = [];
  public MondayList: any = [];
  public TueList: any = [];
  public WedList: any = [];
  public ThursList: any = [];
  public FriList: any = [];
  public SatList: any = [];
  public SunList: any = [];
  public key: boolean = false;
  public counterWeekDayOff: number = 0;
  public btnDisableSun: boolean = false;
  public btnDisableMon: boolean = false;
  public btnDisableTue: boolean = false;
  public btnDisableWed: boolean = false;
  public btnDisableThu: boolean = false;
  public btnDisableFri: boolean = false;
  public btnDisableSat: boolean = false;
  public btnDisable: boolean = false;

  public weekdaysDayOffList: any = {
    Monday: '0',
    Tuesday: '0',
    Wednesday: '0',
    Thursday: '0',
    Friday: '0',
    Saturday: '0',
    Sunday: '0',
  };

  public timeSlots: any = [
    {
      time: '6:00 AM IST',
      value: '6:00',
    },
    {
      time: '6:15 AM IST',
      value: '6:15',
    },
    {
      time: '6:30 AM IST',
    },
    {
      time: '6:45 AM IST',
      value: '6:45',
    },
    {
      time: '7:00 AM IST',
      value: '7:00',
    },
    {
      time: '7:15 AM IST',
      value: '7:15',
    },
    {
      time: '7:30 AM IST',
      value: '7:30',
    },
    {
      time: '7:45 AM IST',
      value: '7:45',
    },
    {
      time: '8:00 AM IST',
      value: '8:00',
    },
    {
      time: '8:15 AM IST',
      value: '8:15',
    },
    {
      time: '8:30 AM IST',
      value: '8:30',
    },
    {
      time: '8:45 AM IST',
      value: '8:45',
    },
    {
      time: '9:00 AM IST',
      value: '9:00',
    },
    {
      time: '9:15 AM IST',
      value: '9:15',
    },
    {
      time: '9:30 AM IST',
      value: '9:30',
    },
    {
      time: '9:45 AM IST',
      value: '9:45',
    },
    {
      time: '10:00 AM IST',
      value: '10:00',
    },
    {
      time: '10:15 AM IST',
      value: '10:15',
    },
    {
      time: '10:30 AM IST',
      value: '10:30',
    },
    {
      time: '10:45 AM IST',
      value: '10:45',
    },
    {
      time: '11:00 AM IST',
      value: '11:00',
    },
    {
      time: '11:15 AM IST',
      value: '11:15',
    },
    {
      time: '11:30 AM IST',
    },
    {
      time: '11:45 AM IST',
    },
    {
      time: '12:00 PM IST',
    },
    {
      time: '12:15 PM IST',
    },
    {
      time: '12:30 PM IST',
    },
    {
      time: '12:45 PM IST',
    },
    {
      time: '1:00 PM IST',
    },
    {
      time: '1:15 PM IST',
    },
    {
      time: '1:30 PM IST',
    },
    {
      time: '1:45 PM IST',
    },
    {
      time: '2:00 PM IST',
    },
    {
      time: '2:15 PM IST',
    },
    {
      time: '2:30 PM IST',
    },
    {
      time: '2:45 PM IST',
    },

   
    { time: '3:00 PM IST' },
    { time: '3:15 PM IST' },
    { time: '3:30 PM IST' },
    { time: '3:45 PM IST' },
    { time: '4:00 PM IST' },
    { time: '4:15 PM IST' },
    { time: '4:30 PM IST' },
    { time: '4:45 PM IST' },
    { time: '5:00 PM IST' },
    { time: '5:15 PM IST' },
    { time: '5:30 PM IST' },
    { time: '5:45 PM IST' },
    { time: '6:00 PM IST' },
    { time: '6:15 PM IST' },
    { time: '6:30 PM IST' },
    { time: '6:45 PM IST' },
    { time: '7:00 PM IST' },
    { time: '7:15 PM IST' },
    { time: '7:30 PM IST' },
    { time: '7:45 PM IST' },
    { time: '8:00 PM IST' },
    { time: '8:15 PM IST' },
    { time: '8:30 PM IST' },
    { time: '8:45 PM IST' },
    { time: '9:00 PM IST' },
    { time: '9:15 PM IST' },
    { time: '9:30 PM IST' },
    { time: '9:45 PM IST' },
    { time: '10:00 PM IST' },
    { time: '10:15 PM IST' },

 
  ];

  constructor(private userData: UserDataService, private fb: FormBuilder) {
    this.checkBoxform = this.fb.group({
      Monday: this.fb.array([]),
      Tuesday: this.fb.array([]),
      Wednesday: this.fb.array([]),
      Thursday: this.fb.array([]),
      Friday: this.fb.array([]),
      Saturday: this.fb.array([]),
      Sunday: this.fb.array([]),
    });
  }

  private teacherAvailability = {
    Monday: [],
    Tuesday: [],
    Wednesday: [],
    Thursday: [],
    Friday: [],
    Saturday: [],
    Sunday: [],
  };

  myForm: any;

  availableData = new FormGroup({
    inpVal: new FormControl(''),
  });

  checked: boolean = false;

  availabilityData = new FormGroup({
    mondaydata: new FormControl('', [Validators.required]),
  });

  onSubmit() {
    let inpData = this.checkBoxform.value;
    console.log(inpData);

    this.userData
      .callApi(
        inpData,
        VariableConstants.METHOD_POST,
        RequestMapper.API_TEACHER_AVAILABILITY,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        console.log(result.body.code);
        if (result.body.code == 200) {
          alert(result.body.message);
        } else if (result.body.code == 203) {
          alert(result.body.message);
        } else {
          alert('wrong api');
        }
      });
  }

  onChangeWeekDays(e: any, day: string) {
    debugger;
    const checkArray: FormArray = this.checkBoxform.get(day) as FormArray;
    if (e.target.checked) {
      checkArray.push(new FormControl(e.target.value));
    } else {
      let i: number = 0;
      checkArray.controls.forEach((item: any) => {
        if (item.value == e.target.value) {
          checkArray.removeAt(i);
          return;
        }
        i++;
      });
    }
  }

  onDayOffSelectSun(e: any, day: string) {
    debugger;
    let sumOfday = 0;
    for (let dayName in this.weekdaysDayOffList) {
      let val;
      if (!isNaN(this.weekdaysDayOffList[dayName])) {
        val = parseInt(this.weekdaysDayOffList[dayName], 10);
        sumOfday += val;
      }
    }

    if (sumOfday > 1) {
      alert('More than two daysoff is not possible');
    }

    console.log('Sum val', sumOfday);
    console.log(e, day);

    if (this.btnDisableSun == false) {
      this.weekdaysDayOffList[day] += 1;
    } else {
      this.weekdaysDayOffList[day] = 0;
    }

    console.log(this.counterWeekDayOff);

    if (this.weekdaysDayOffList[day] >= 1) {
      this.btnDisableSun = true;
    }
    if (this.weekdaysDayOffList[day] == 0) {
      this.btnDisableSun = false;
    }
    console.log(this.btnDisable);
    console.log(this.weekdaysDayOffList[day]);
  }
  onDayOffSelectMon(e: any, day: string) {
    debugger;

    let sumOfday = 0;
    for (let dayName in this.weekdaysDayOffList) {
      let val;
      if (!isNaN(this.weekdaysDayOffList[dayName])) {
        val = parseInt(this.weekdaysDayOffList[dayName], 10);
        sumOfday += val;
      }
    }

    if (sumOfday > 1) {
      alert('More than two daysoff is not possible');
    }

    console.log('Sum val', sumOfday);
    console.log(e, day);

    if (this.btnDisableMon == false) {
      this.weekdaysDayOffList[day] += 1;
    } else {
      this.weekdaysDayOffList[day] = 0;
    }

    console.log(this.counterWeekDayOff);

    if (this.weekdaysDayOffList[day] >= 1) {
      this.btnDisableMon = true;
    }
    if (this.weekdaysDayOffList[day] == 0) {
      this.btnDisableMon = false;
    }
    console.log(this.btnDisable);
    console.log(this.weekdaysDayOffList[day]);
  }
  onDayOffSelectTue(e: any, day: string) {
    debugger;
    let sumOfday = 0;

    for (let dayName in this.weekdaysDayOffList) {
      let val;
      if (!isNaN(this.weekdaysDayOffList[dayName])) {
        val = parseInt(this.weekdaysDayOffList[dayName], 10);
        sumOfday += val;
      }
    }

    if (sumOfday > 1) {
      alert('More than two daysoff is not possible');
    }

    console.log('Sum val', sumOfday);
    console.log(e, day);

    if (this.btnDisableTue == false) {
      this.weekdaysDayOffList[day] += 1;
    } else {
      this.weekdaysDayOffList[day] = 0;
    }

    console.log(this.counterWeekDayOff);

    if (this.weekdaysDayOffList[day] >= 1) {
      this.btnDisableTue = true;
    }
    if (this.weekdaysDayOffList[day] == 0) {
      this.btnDisableTue = false;
    }
    console.log(this.btnDisable);
    console.log(this.weekdaysDayOffList[day]);
  }
  onDayOffSelectWed(e: any, day: string) {
    debugger;

    let sumOfday = 0;
    for (let dayName in this.weekdaysDayOffList) {
      let val;
      if (!isNaN(this.weekdaysDayOffList[dayName])) {
        val = parseInt(this.weekdaysDayOffList[dayName], 10);
        sumOfday += val;
      }
    }

    if (sumOfday > 1) {
      alert('More than two daysoff is not possible');
    }

    console.log('Sum val', sumOfday);
    console.log(e, day);

    if (this.btnDisableWed == false) {
      this.weekdaysDayOffList[day] += 1;
    } else {
      this.weekdaysDayOffList[day] = 0;
    }

    console.log(this.counterWeekDayOff);

    if (this.weekdaysDayOffList[day] >= 1) {
      this.btnDisableWed = true;
    }
    if (this.weekdaysDayOffList[day] == 0) {
      this.btnDisableWed = false;
    }
    console.log(this.btnDisable);
    console.log(this.weekdaysDayOffList[day]);
  }
  onDayOffSelectThu(e: any, day: string) {
    debugger;

    let sumOfday = 0;
    for (let dayName in this.weekdaysDayOffList) {
      let val;
      if (!isNaN(this.weekdaysDayOffList[dayName])) {
        val = parseInt(this.weekdaysDayOffList[dayName], 10);
        sumOfday += val;
      }
    }

    if (sumOfday > 1) {
      alert('More than two daysoff is not possible');
    }

    console.log('Sum val', sumOfday);
    console.log(e, day);

    if (this.btnDisableThu == false) {
      this.weekdaysDayOffList[day] += 1;
    } else {
      this.weekdaysDayOffList[day] = 0;
    }

    console.log(this.counterWeekDayOff);

    if (this.weekdaysDayOffList[day] >= 1) {
      this.btnDisableThu = true;
    }
    if (this.weekdaysDayOffList[day] == 0) {
      this.btnDisableThu = false;
    }
    console.log(this.btnDisable);
    console.log(this.weekdaysDayOffList[day]);
  }
  onDayOffSelectFri(e: any, day: string) {
    debugger;

    let sumOfday = 0;
    for (let dayName in this.weekdaysDayOffList) {
      let val;
      if (!isNaN(this.weekdaysDayOffList[dayName])) {
        val = parseInt(this.weekdaysDayOffList[dayName], 10);
        sumOfday += val;
      }
    }

    if (sumOfday > 1) {
      alert('More than two daysoff is not possible');
    }

    console.log('Sum val', sumOfday);
    console.log(e, day);

    if (this.btnDisableFri == false) {
      this.weekdaysDayOffList[day] += 1;
    } else {
      this.weekdaysDayOffList[day] = 0;
    }

    console.log(this.counterWeekDayOff);

    if (this.weekdaysDayOffList[day] >= 1) {
      this.btnDisableFri = true;
    }
    if (this.weekdaysDayOffList[day] == 0) {
      this.btnDisableFri = false;
    }
    console.log(this.btnDisable);
    console.log(this.weekdaysDayOffList[day]);
  }
  onDayOffSelectSat(e: any, day: string) {
    debugger;

    let sumOfday = 0;
    for (let dayName in this.weekdaysDayOffList) {
      let val;
      if (!isNaN(this.weekdaysDayOffList[dayName])) {
        val = parseInt(this.weekdaysDayOffList[dayName], 10);
        sumOfday += val;
      }
    }

    if (sumOfday > 1) {
      alert('More than two daysoff is not possible');
    }

    console.log('Sum val', sumOfday);
    console.log(e, day);

    if (this.btnDisableSat == false) {
      this.weekdaysDayOffList[day] += 1;
    } else {
      this.weekdaysDayOffList[day] = 0;
    }

    console.log(this.counterWeekDayOff);

    if (this.weekdaysDayOffList[day] >= 1) {
      this.btnDisableSat = true;
    }
    if (this.weekdaysDayOffList[day] == 0) {
      this.btnDisableSat = false;
    }
    console.log(this.btnDisable);
    console.log(this.weekdaysDayOffList[day]);
  }

  all: any = [];
  date_time: any = [];

  ngOnInit(): void {
    this.MondayList = [];
    this.TueList = [];
    this.WedList = [];
    this.ThursList = [];
    this.FriList = [];
    this.SatList = [];
    this.SunList = [];
    this.date_time = [
      [
        {
          Monday: [
            '6:00',
            '6:15',
            '6:30',
            '6:45',
            '7:00',
            '7:15',
            '7:30',
            '7:45',
            '8:00',
            '8:15',
            '8:30',
            '8:45',
            '9:00',
            '9:15',
            '9:30',
            '9:45',
            '10:00',
            '10:15',
            '10:30',
            '10:45',
            '11:00',
            '11:15',
            '11:30',
            '11:45',
            '12:00',
            '12:15',
            '12:30',
            '12:45',
            '13:00',
            '13:15',
            '13:30',
            '13:45',
            '14:00',
            '14:15',
            '14:30',
            '14:45',
            '15:00',
            '15:15',
            '15:30',
            '15:45',
            '16:00',
            '16:15',
            '16:30',
            '16:45',
            '17:00',
            '17:15',
            '17:30',
            '17:45',
            '18:00',
            '18:15',
            '18:30',
            '18:45',
            '19:00',
            '19:15',
            '19:30',
            '19:45',
            '20:00',
            '20:15',
            '20:30',
            '20:45',
            '21:00',
            '21:15',
            '21:30',
            '21:45',
            '22:00',
            '22:15',
            '22:30',
          ],
        },
      ],
      [
        {
          Tuesday: [
            '6:00',
            '6:15',
            '6:30',
            '6:45',
            '7:00',
            '7:15',
            '7:30',
            '7:45',
            '8:00',
            '8:15',
            '8:30',
            '8:45',
            '9:00',
            '9:15',
            '9:30',
            '9:45',
            '10:00',
            '10:15',
            '10:30',
            '10:45',
            '11:00',
            '11:15',
            '11:30',
            '11:45',
            '12:00',
            '12:15',
            '12:30',
            '12:45',
            '13:00',
            '13:15',
            '13:30',
            '13:45',
            '14:00',
            '14:15',
            '14:30',
            '14:45',
            '15:00',
            '15:15',
            '15:30',
            '15:45',
            '16:00',
            '16:15',
            '16:30',
            '16:45',
            '17:00',
            '17:15',
            '17:30',
            '17:45',
            '18:00',
            '18:15',
            '18:30',
            '18:45',
            '19:00',
            '19:15',
            '19:30',
            '19:45',
            '20:00',
            '20:15',
            '20:30',
            '20:45',
            '21:00',
            '21:15',
            '21:30',
            '21:45',
            '22:00',
            '22:15',
            '22:30',
          ],
        },
      ],
      [
        {
          Wednesday: [
            '6:00',
            '6:15',
            '6:30',
            '6:45',
            '7:00',
            '7:15',
            '7:30',
            '7:45',
            '8:00',
            '8:15',
            '8:30',
            '8:45',
            '9:00',
            '9:15',
            '9:30',
            '9:45',
            '10:00',
            '10:15',
            '10:30',
            '10:45',
            '11:00',
            '11:15',
            '11:30',
            '11:45',
            '12:00',
            '12:15',
            '12:30',
            '12:45',
            '13:00',
            '13:15',
            '13:30',
            '13:45',
            '14:00',
            '14:15',
            '14:30',
            '14:45',
            '15:00',
            '15:15',
            '15:30',
            '15:45',
            '16:00',
            '16:15',
            '16:30',
            '16:45',
            '17:00',
            '17:15',
            '17:30',
            '17:45',
            '18:00',
            '18:15',
            '18:30',
            '18:45',
            '19:00',
            '19:15',
            '19:30',
            '19:45',
            '20:00',
            '20:15',
            '20:30',
            '20:45',
            '21:00',
            '21:15',
            '21:30',
            '21:45',
            '22:00',
            '22:15',
            '22:30',
          ],
        },
      ],
      [
        {
          Thursday: [
            '6:00',
            '6:15',
            '6:30',
            '6:45',
            '7:00',
            '7:15',
            '7:30',
            '7:45',
            '8:00',
            '8:15',
            '8:30',
            '8:45',
            '9:00',
            '9:15',
            '9:30',
            '9:45',
            '10:00',
            '10:15',
            '10:30',
            '10:45',
            '11:00',
            '11:15',
            '11:30',
            '11:45',
            '12:00',
            '12:15',
            '12:30',
            '12:45',
            '13:00',
            '13:15',
            '13:30',
            '13:45',
            '14:00',
            '14:15',
            '14:30',
            '14:45',
            '15:00',
            '15:15',
            '15:30',
            '15:45',
            '16:00',
            '16:15',
            '16:30',
            '16:45',
            '17:00',
            '17:15',
            '17:30',
            '17:45',
            '18:00',
            '18:15',
            '18:30',
            '18:45',
            '19:00',
            '19:15',
            '19:30',
            '19:45',
            '20:00',
            '20:15',
            '20:30',
            '20:45',
            '21:00',
            '21:15',
            '21:30',
            '21:45',
            '22:00',
            '22:15',
            '22:30',
          ],
        },
      ],
      [
        {
          Friday: [
            '6:00',
            '6:15',
            '6:30',
            '6:45',
            '7:00',
            '7:15',
            '7:30',
            '7:45',
            '8:00',
            '8:15',
            '8:30',
            '8:45',
            '9:00',
            '9:15',
            '9:30',
            '9:45',
            '10:00',
            '10:15',
            '10:30',
            '10:45',
            '11:00',
            '11:15',
            '11:30',
            '11:45',
            '12:00',
            '12:15',
            '12:30',
            '12:45',
            '13:00',
            '13:15',
            '13:30',
            '13:45',
            '14:00',
            '14:15',
            '14:30',
            '14:45',
            '15:00',
            '15:15',
            '15:30',
            '15:45',
            '16:00',
            '16:15',
            '16:30',
            '16:45',
            '17:00',
            '17:15',
            '17:30',
            '17:45',
            '18:00',
            '18:15',
            '18:30',
            '18:45',
            '19:00',
            '19:15',
            '19:30',
            '19:45',
            '20:00',
            '20:15',
            '20:30',
            '20:45',
            '21:00',
            '21:15',
            '21:30',
            '21:45',
            '22:00',
            '22:15',
            '22:30',
          ],
        },
      ],
      [
        {
          Saturday: [
            '6:00',
            '6:15',
            '6:30',
            '6:45',
            '7:00',
            '7:15',
            '7:30',
            '7:45',
            '8:00',
            '8:15',
            '8:30',
            '8:45',
            '9:00',
            '9:15',
            '9:30',
            '9:45',
            '10:00',
            '10:15',
            '10:30',
            '10:45',
            '11:00',
            '11:15',
            '11:30',
            '11:45',
            '12:00',
            '12:15',
            '12:30',
            '12:45',
            '13:00',
            '13:15',
            '13:30',
            '13:45',
            '14:00',
            '14:15',
            '14:30',
            '14:45',
            '15:00',
            '15:15',
            '15:30',
            '15:45',
            '16:00',
            '16:15',
            '16:30',
            '16:45',
            '17:00',
            '17:15',
            '17:30',
            '17:45',
            '18:00',
            '18:15',
            '18:30',
            '18:45',
            '19:00',
            '19:15',
            '19:30',
            '19:45',
            '20:00',
            '20:15',
            '20:30',
            '20:45',
            '21:00',
            '21:15',
            '21:30',
            '21:45',
            '22:00',
            '22:15',
            '22:30',
          ],
        },
      ],
      [
        {
          Sunday: [
            '6:00',
            '6:15',
            '6:30',
            '6:45',
            '7:00',
            '7:15',
            '7:30',
            '7:45',
            '8:00',
            '8:15',
            '8:30',
            '8:45',
            '9:00',
            '9:15',
            '9:30',
            '9:45',
            '10:00',
            '10:15',
            '10:30',
            '10:45',
            '11:00',
            '11:15',
            '11:30',
            '11:45',
            '12:00',
            '12:15',
            '12:30',
            '12:45',
            '13:00',
            '13:15',
            '13:30',
            '13:45',
            '14:00',
            '14:15',
            '14:30',
            '14:45',
            '15:00',
            '15:15',
            '15:30',
            '15:45',
            '16:00',
            '16:15',
            '16:30',
            '16:45',
            '17:00',
            '17:15',
            '17:30',
            '17:45',
            '18:00',
            '18:15',
            '18:30',
            '18:45',
            '19:00',
            '19:15',
            '19:30',
            '19:45',
            '20:00',
            '20:15',
            '20:30',
            '20:45',
            '21:00',
            '21:15',
            '21:30',
            '21:45',
            '22:00',
            '22:15',
            '22:30',
          ],
        },
      ],
    ];

    // this.date_time = weekdata;
    // console.log(weekdata[0]);

    this.avaialibilityApi();
    setTimeout(() => {
      this.checkAvail();
    }, 3000);
    // this.checkAvail();
  }

  selectedtime: string = '';

  avaialibilityApi() {
    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_TEACHER_COOKIE_CUTNIP,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe({
        next: (result) => {
          console.log(JSON.parse(result.data.availability));
          let availableData = JSON.parse(result.data.availability);
          this.availData = availableData;

          console.log(this.availData);
          debugger;
          console.log(this.availData['Monday'][0]);

          this.MondayList = this.availData['Monday'];
          this.TueList = this.availData['Tuesday'];
          this.WedList = this.availData['Wednesday'];
          this.ThursList = this.availData['Thursday'];
          this.FriList = this.availData['Friday'];
          this.SatList = this.availData['Saturday'];
          this.SunList = this.availData['Sunday'];
          debugger;
          console.log(this.MondayList);
          console.log(this.TueList);
          console.log(this.ThursList);

          // availableData.forEach((value: any) => {
          //   console.log(value.from);
          //   this.isChecked = new Date(value.to);
          //   let newHrs = this.isChecked.getHours();
          //   let newMins = this.isChecked.getMinutes();
          //   console.log('current time =' + newHrs + ':' + newMins);
          //   // sunday
          //   if (this.isChecked.getDay() === 0) {
          //     this.SunList.push({
          //       time: newHrs + ':' + newMins,
          //     });
          //   }
          //   // Mon
          //   if (this.isChecked.getDay() === 1) {
          //     this.MondayList.push({
          //       time: newHrs + ':' + newMins,
          //     });
          //   }
          //   // Tue
          //   if (this.isChecked.getDay() === 2) {
          //     this.TueList.push({
          //       time: newHrs + ':' + newMins,
          //     });
          //   }
          //   // Wed
          //   if (this.isChecked.getDay() === 3) {
          //     this.WedList.push({
          //       time: newHrs + ':' + newMins,
          //     });
          //   }
          //   // Thurs
          //   if (this.isChecked.getDay() === 4) {
          //     this.ThursList.push({
          //       time: newHrs + ':' + newMins,
          //     });
          //   }
          //   // Fri
          //   if (this.isChecked.getDay() === 5) {
          //     this.FriList.push({
          //       time: newHrs + ':' + newMins,
          //     });
          //   }
          //   // Sat
          //   if (this.isChecked.getDay() === 6) {
          //     this.SatList.push({
          //       time: newHrs + ':' + newMins,
          //     });
          //   }
          //   this.avaliList.push({
          //     time: value.from,
          //   });
          // });
          // console.log(this.avaliList);
          // console.log(this.MondayList);
          // console.log(this.TueList);
          // console.log(this.SatList);
          // console.log(this.SunList);

          // console.log(this.key);
        },
        error: (err) => {},
      });
  }

  checkAvail() {
    // debugger;
    // Monday
    this.date_time[0].forEach((value: any) => {
      debugger;
      console.log('dateTime', value);
      value.Monday.forEach((val: any) => {
        // console.log('date', val);
        let monVal = (document.getElementById(val) as HTMLInputElement).value;

        if (this.MondayList.length == 0) {
          (document.getElementById(monVal) as HTMLInputElement).disabled = true;
          (document.getElementById('mon_Dayoff') as HTMLInputElement).checked =
            true;
        }

        this.MondayList.forEach((monTiming: any) => {
          console.log('MondayVal', monTiming);
          if (monVal == monTiming) {
            (document.getElementById(monVal) as HTMLInputElement).checked =
              true;
          }
        });
      });
    });

    // Tuesday
    this.date_time[1].forEach((value: any) => {
      debugger;
      value.Tuesday.forEach((val: any) => {
        let tueVal = (
          document.getElementById('tue' + '_' + val) as HTMLInputElement
        ).value;

        if (this.TueList.length == 0) {
          (
            document.getElementById('tue' + '_' + val) as HTMLInputElement
          ).disabled = true;
          (document.getElementById('tue_Dayoff') as HTMLInputElement).checked =
            true;
        }

        this.TueList.forEach((tueTiming: any) => {
          if (tueVal == tueTiming) {
            (
              document.getElementById('tue' + '_' + val) as HTMLInputElement
            ).checked = true;
          }
        });

        // console.log(monVal);
        // if (tueVal == this.TueList) {
        //   (
        //     document.getElementById('tue' + '_' + val) as HTMLInputElement
        //   ).checked = true;
        // }
      });
    });

    // Wed
    this.date_time[2].forEach((value: any) => {
      value.Wednesday.forEach((val: any) => {
        let wedVal = (
          document.getElementById('wed' + '_' + val) as HTMLInputElement
        ).value;

        if (this.WedList.length == 0) {
          (
            document.getElementById('wed' + '_' + val) as HTMLInputElement
          ).disabled = true;
          (document.getElementById('wed_Dayoff') as HTMLInputElement).checked =
            true;
        }

        this.WedList.forEach((wedTiming: any) => {
          if (wedVal == wedTiming) {
            (
              document.getElementById('wed' + '_' + val) as HTMLInputElement
            ).checked = true;
          }
        });

        // console.log(monVal);
        // if (monVal == this.WedList) {
        //   (
        //     document.getElementById('wed' + '_' + val) as HTMLInputElement
        //   ).checked = true;
        // }
      });
    });

    // Thrs
    this.date_time[3].forEach((value: any) => {
      value.Thursday.forEach((val: any) => {
        let thuVal = (
          document.getElementById('thrs' + '_' + val) as HTMLInputElement
        ).value;

        if (this.ThursList.length == 0) {
          (
            document.getElementById('thrs' + '_' + val) as HTMLInputElement
          ).disabled = true;
          (document.getElementById('thrs_Dayoff') as HTMLInputElement).checked =
            true;
        }

        this.ThursList.forEach((thuTiming: any) => {
          if (thuVal == thuTiming) {
            (
              document.getElementById('thrs' + '_' + val) as HTMLInputElement
            ).checked = true;
          }
        });

        // console.log(monVal);
        // if (monVal == this.ThursList) {
        //   (
        //     document.getElementById('thrs' + '_' + val) as HTMLInputElement
        //   ).checked = true;
        // }
      });
    });

    // Fri
    this.date_time[4].forEach((value: any) => {
      value.Friday.forEach((val: any) => {
        let friVal = (
          document.getElementById('fri' + '_' + val) as HTMLInputElement
        ).value;

        if (this.FriList.length == 0) {
          (
            document.getElementById('fri' + '_' + val) as HTMLInputElement
          ).disabled = true;
          (document.getElementById('fri_Dayoff') as HTMLInputElement).checked =
            true;
        }

        // console.log(monVal);
        this.FriList.forEach((friTiming: any) => {
          if (friVal == friTiming) {
            (
              document.getElementById('thrs' + '_' + val) as HTMLInputElement
            ).checked = true;
          }
        });
      });
    });

    // Sat
    this.date_time[5].forEach((value: any) => {
      value.Saturday.forEach((val: any) => {
        let satVal = (
          document.getElementById('sat' + '_' + val) as HTMLInputElement
        ).value;

        if (this.SatList.length == 0) {
          (
            document.getElementById('sat' + '_' + val) as HTMLInputElement
          ).disabled = true;
          (document.getElementById('sat_Dayoff') as HTMLInputElement).checked =
            true;
        }

        // console.log(monVal);
        this.SatList.forEach((satTiming: any) => {
          if (satVal == satTiming) {
            (
              document.getElementById('thrs' + '_' + val) as HTMLInputElement
            ).checked = true;
          }
        });
      });
    });

    // Sun
    this.date_time[6].forEach((value: any) => {
      value.Sunday.forEach((val: any) => {
        let sunVal = (
          document.getElementById('sun' + '_' + val) as HTMLInputElement
        ).value;

        // console.log(monVal);

        if (this.SunList.length == 0) {
          (
            document.getElementById('sun' + '_' + val) as HTMLInputElement
          ).disabled = true;
          (document.getElementById('sun_Dayoff') as HTMLInputElement).checked =
            true;
        }

        this.SunList.forEach((sunTiming: any) => {
          if (sunVal == sunTiming) {
            (
              document.getElementById('thrs' + '_' + val) as HTMLInputElement
            ).checked = true;
          }
        });
      });
    });
  }
}
