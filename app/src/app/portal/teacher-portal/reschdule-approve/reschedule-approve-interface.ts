
export interface reschedule_approve {
    data: [
        {
            id: string,
            user_id: string,
            class_id: string,
            availability_id: string,
            rescheduled_date: string,
            reason_for_reschedule: string,
            status: string,
            created_by: string,
            updated_by: string,
            created_on: string,
            updated_on: string,
            user_fullname: string,
            user_type: string
        }
    ]
  }
  export interface reschedule_weak_interface {
    
        Monday:object,
       Tuesday:object,
       Wednesday:object,
       Thursday:object,
       Friday:object,
       Saturday:object,
       Sunday:object         
    
  }
  