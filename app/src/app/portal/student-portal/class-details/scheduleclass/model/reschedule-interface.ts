import { Reschedule } from 'src/app/basic-module/reschedule/interface/reschedule-interface';
export class RescheduleModel {
  private static readonly rescheduleobj: Reschedule[] = [
    {
      time: '07:30 PM Saturday, May 28, 2-23 1',
      checked: false,
      id: '1',
    },
    {
      time: '07:30 PM Saturday, May 28, 2-23 2',
      checked: false,
      id: '2',
    },
    {
      time: '07:30 PM Saturday, May 28, 2-23 3',
      checked: true,
      id: '3',
    },
    {
      time: '07:30 PM Saturday, May 28, 2-23 4',
      checked: false,
      id: '4',
    },
    {
      time: '07:30 PM Saturday, May 28, 2-23 5',
      checked: false,
      id: '5',
    },
    {
      time: '07:30 PM Saturday, May 28, 2-23 6',
      checked: false,
      id: '6',
    },
    {
      time: '07:30 PM Saturday, May 28, 2-23 7',
      checked: false,
      id: '7',
    },
  ];

  public static get returnMethod() {
    return RescheduleModel.rescheduleobj;
  }
}


export interface UserAvailableInterface
{
  data: [
  {
      id: string,
      user_id: string,
      status: string,
      from: string,
      to: string,
      created_by: string,
      updated_by: string,
      created_on: string,
      updated_on: string,
      user_fullname: string
  }
  ]
}



export interface UserRescheduleGet
{

        id:string,
        user_id: string,
        class_id:string,
        reason_for_reschedule: string,
        status: string,
        created_by: string,
        updated_by: string,
        created_on:string,
        updated_on: string

}



