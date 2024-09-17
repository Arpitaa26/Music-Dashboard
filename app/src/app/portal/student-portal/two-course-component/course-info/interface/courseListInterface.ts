export interface CourseListInterface {
  img: string;
  topHead: string;
  author: string;
}



export interface CourseEnrollmentInterface{
  data: [
    {
            id: string,
            user_id: string,
            course_id: string,
            course_level_id: string,
            batch_id: string,
            category: string,
            referral_code_used: string,
            modules_completed: string,
            attendance: string,
            classes_purchased:string,
            classes_used: string,
            status: string,
            created_by: string,
            updated_by: string,
            created_on:string,
            updated_on:string,
            user_fullname: string,
            short_description: string,
            description: string,
            course_name: string,
            batch_code:string,
            level: string,
            file_name:string,
            slug:any
    }
  ]
}
