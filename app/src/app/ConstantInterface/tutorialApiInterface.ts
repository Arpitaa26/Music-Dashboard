import { ResponseApiStatic } from './commonRespInterface';

export interface TutorialGetApi extends ResponseApiStatic {
  data: TutorialGetApiObj[];
}

export interface TutorialGetApiObj {
  created_by: string;
  created_on: string;
  description: string;
  id: string;
  module_id: string;
  module_name: string;
  order: string;
  status: string;
  title: string;
  updated_by: string;
  updated_on: string;
  batch_id:string
}
