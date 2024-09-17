import { ResponseApiStatic } from './commonRespInterface';

export interface ModuleListLevelApi extends ResponseApiStatic {
  data: ModuleListLevelApiObj[];
}

export interface ModuleListLevelApiObj {
  created_by: string;
  created_on: string;
  description: string;
  id: string;
  level: string;
  status: string;
  updated_by: string;
  updated_on: string;
}
