import { ResponseApiStatic } from './commonRespInterface';

export interface ModuleListGetdata {
  data: ModuleListGetApiObj[];
}
export interface ModuleListGetApi extends ResponseApiStatic {
  data: ModuleListGetApiObj[];
}

export interface ModuleListGetApiObj {
  course_id: string;
  course_level: string;
  course_level_id: string;
  course_name: string;
  created_by: string;
  created_on: string;
  description: string;
  id: string;
  name: string;
  order: string;
  status: string;
  updated_by: string;
  updated_on: string;
}
