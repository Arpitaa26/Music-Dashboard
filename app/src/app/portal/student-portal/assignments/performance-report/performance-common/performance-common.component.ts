import { Component, OnInit } from '@angular/core';
import { PerfonamcCommonList } from './model/perfonamc-common-list';
import { Perfonamccommon } from './interface/perfonamccommon';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-performance-common',
  templateUrl: './performance-common.component.html',
  styleUrls: ['./performance-common.component.scss']
})
export class PerformanceCommonComponent implements OnInit {

  constructor(private router: Router, private activeRoute: ActivatedRoute) { }
  performanceCommonObj:Perfonamccommon = PerfonamcCommonList.methPerfonamcCommonList
  heading = this.performanceCommonObj.heading;
  ngOnInit(): void {
    console.log(this.performanceCommonObj)
    this.heading
    this.performanceCommonObj.heading = this.performanceCommonObj.heading +' '+ this.activeRoute.snapshot.paramMap.get('id');
  }
  ngOnDestroy(): void {
    this.performanceCommonObj.heading = this.heading;
  }
}
