export interface AudioArchiveInterface {
    
        id: string;
        file_name: string;
        slug: string;
        category: string;
        mime_type: string;
        path: string;
        status: string;
        created_by: string;
        updated_by: string;
        created_on: string;
        updated_on: string;
        description: string;
        feedback:string
      }
  
      export interface IAudioArchiveResp {
    
       data:AudioArchiveInterface [];
       message:string;
       code:string
      }