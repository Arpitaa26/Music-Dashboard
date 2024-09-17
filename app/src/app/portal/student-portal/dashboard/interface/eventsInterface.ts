export interface EventsImage {
  image: string;
  thumbImage: string;
  title?: string;
  mediaType: string;
}


export interface BulletinEventInterface {
  data: [
    {
        ID: string,
        title: string,
        description: string,
        start_date: string,
        end_date: string,
        bg_color: null,
        text_color: null,
        created_by: string,
        updated_by: string,
        created_on: any,
        updated_on: null,
        file_name:string,
        slug:string,
        event_link:any;
    }
]
}

