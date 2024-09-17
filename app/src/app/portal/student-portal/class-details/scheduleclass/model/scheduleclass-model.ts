import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import { ScheduleClassInterface, ScheduleStatusEnum } from '../interface/scheduleclass-interface';

export class ScheduleclassModel {
  private static readonly scheduleclassObj: ScheduleClassInterface[] = [

    {
      "id": "1",
      "batch_id": "1",
      "session_id": "1",
      "module_id": "7",
      "user_id": "22",
      "status": ScheduleStatusEnum.STARTED,
      "start_time": "2023-05-09",
      "end_time": "2023-05-09",
      "description": "asdasd",
      "link": "https:\/\/www.google.com",
      "recorded_link": "",
      "level": "asdasd",
      "created_by": "3",
      "updated_by": "0",
      "created_on": "2023-05-09 12:16:26",
      "updated_on": "2023-05-09 12:16:26",
      "session_type": "ONLINE",
      "batch_code": "P001",
      "module_name": "Module 1",
      "students": "Module 1",
      "class_no": "1",
      "currency": "1",
    },{
      "id": "1",
      "batch_id": "1",
      "session_id": "1",
      "module_id": "7",
      "user_id": "22",
      "status": ScheduleStatusEnum.STARTED,
      "start_time": "2023-05-09",
      "end_time": "2023-05-09",
      "description": "asdasd",
      "link": "https:\/\/www.google.com",
      "recorded_link": "",
      "level": "asdasd",
      "created_by": "3",
      "updated_by": "0",
      "created_on": "2023-05-09 12:16:26",
      "updated_on": "2023-05-09 12:16:26",
      "session_type": "ONLINE",
      "batch_code": "P001",
      "module_name": "Module 1",
      "students": "Module 1",
      "class_no": "1",
      "currency": "1",
    },{
      "id": "1",
      "batch_id": "1",
      "session_id": "1",
      "module_id": "7",
      "user_id": "22",
      "status": ScheduleStatusEnum.STARTED,
      "start_time": "2023-05-09",
      "end_time": "2023-05-09",
      "description": "asdasd",
      "link": "https:\/\/www.google.com",
      "recorded_link": "",
      "level": "asdasd",
      "created_by": "3",
      "updated_by": "0",
      "created_on": "2023-05-09 12:16:26",
      "updated_on": "2023-05-09 12:16:26",
      "session_type": "ONLINE",
      "batch_code": "P001",
      "module_name": "Module 1",
      "students": "Module 1",
      "class_no": "1",
      "currency": "1",
    }

  ];

  public static get returnMethod() {
    if (!VariableConstants.IS_LOCAL)
      return [];
    else
      return ScheduleclassModel.scheduleclassObj;
  }
}
