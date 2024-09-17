export interface  ICalendarResponse {
    status : number;
    data : ICalendarItem[];
    message:string
}

export interface ICalendarItem {
    id:string;
    status : CalendarStatusEnum;
    module_name : string;
    start_time : string;
    batch_id: string;
    batch_code: string;
    students: string;
    class_no: string;
}

export enum CalendarStatusEnum {
    NOT_STARTED = 'NOT_STARTED',
    RESCHEDULED = 'RESCHEDULED',
    STARTED = 'STARTED',
    COMPLETED = 'COMPLETED',
    PENDING = 'PENDING'


}