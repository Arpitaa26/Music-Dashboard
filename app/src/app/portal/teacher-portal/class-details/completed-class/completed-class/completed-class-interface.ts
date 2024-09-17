export interface apply_filter{
    data: [
      {
          id: string,
          user_id: string,
          course_id: string,
          course_level_id: string,
          batch_id: string,
         
      }
  ]
  
  }

  
export interface ScheduleClassInterface{
    data: [
      {
    id: String,
    batch_id: String,
    session_id: String,
    module_id: String,
    user_id: String,
    status: String,
    start_time: any,
    end_time:any,
    description: String,
    link: String,
    recorded_link: String,
    level: String,
    created_by: String,
    updated_by: String,
    created_on: String,
    updated_on: String,
    session_type: String,
    batch_code: String,
    module_name: String,
    full_name: String,
    home_work: string,
    teacher_note: string,
    rescheduled_date: any,
    actual_start_time: any,
    actual_end_time: any,
    
  }]
  }