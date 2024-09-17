import { Component, Input, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-overview',
  templateUrl: './overview.component.html',
  styleUrls: ['./overview.component.scss'],
})
export class OverviewComponent implements OnInit {
  @Input() data: any;
@Input()dId:any;
@Input()show_node:any;
  constructor(private route: Router) {
   // console.log(this.data);
  }
  uId:any
  ngOnInit(): void {
    console.log(this.data);
    let courseId = this.route.url.split('/').slice(2)[3];
      let levelId = this.route.url.split('/').slice(-1)[0];
      this.uId = this.route.url.split('/').slice(2)[6];
  }
}
