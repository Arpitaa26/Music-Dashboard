import { Component, OnInit } from '@angular/core';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';

@Component({
  selector: 'app-coa-cwa-report',
  templateUrl: './coa-cwa-report.component.html',
  styleUrls: ['./coa-cwa-report.component.scss']
})
export class CoaCwaReportComponent implements OnInit{
  constructor(private userData: UserDataService) {}
  
  report:any=[]
  
  ngOnInit(): void { 
    this.userData.callApi(
      {},
      VariableConstants.METHOD_GET,
      RequestMapper.API_COA_CWA_GET_ALL,
      VariableConstants.ACCESS_PRIVATE
    ).subscribe((result: any) => {
      this.report = result;
      //  console.log(this.report?.data.filter(item));
      
    });
  }
  
}
