import { ResponseApiStatic } from './commonRespInterface';

export interface CourseListApiData extends ResponseApiStatic {
  data: CourseListApiObj[];
}

export interface CourseListApiObj {
  code: string;
  created_by: string;
  created_on: string;
  description: string;
  id: string;
  name: string;
  price: string;
  role: string;
  short_description: string;
  status: string;
  updated_by: string;
  updated_on: string;
}
