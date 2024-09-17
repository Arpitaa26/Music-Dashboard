import { Component, Input } from '@angular/core';
import { FormBuilder } from '@angular/forms';
import { Router } from '@angular/router';
import { UserDataService } from 'src/app/services/user-data.service';

@Component({
  selector: 'app-card',
  templateUrl: './card.component.html',
  styleUrls: ['./card.component.scss']
})
export class CardComponent {
  @Input() card: any;
  @Input() show: boolean = true;


  response_data: any;
  response_datas: any;
  gsmVal: any;
  gsmQuantVal: any;
  constructor(
    private userData: UserDataService,
    private router: Router,
    private fb: FormBuilder
  ) {}
  base_url:any;
  ngOnInit(): void {
    this.base_url = 'https://thesvpacademy.com/admin/file/open/';

  }
  onSubmit(data: any) {
    this.gsmQuantVal = data;

    if (data.lavel && data.type) {
      this.router.navigate([
        
        '/portal/students/course_info/all-courses',
        data.course_id,
        data.lavel,
        data.type,
      ]);
    }
  }
}
