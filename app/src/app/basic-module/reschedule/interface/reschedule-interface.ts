export interface Reschedule {
  time:string,
  checked:boolean,
  id:string
}
export interface reschedule_get{
  data: [
    id: String,
    user_id: String,
    class_id: String,
    reason_for_reschedule: String,
    status: String,
    created_on: string
  ]
}

