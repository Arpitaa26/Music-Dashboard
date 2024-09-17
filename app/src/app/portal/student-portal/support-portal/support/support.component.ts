import { Component, OnInit } from '@angular/core';
import de from 'date-fns/esm/locale/de/index.js';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';

@Component({
  selector: 'app-support',
  templateUrl: './support.component.html',
  styleUrls: ['./support.component.scss'],
})
export class SupportComponent implements OnInit {
  tableData: any;
  constructor(private userData: UserDataService) {}
  status:any;
  ngOnInit(): void {
    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_TASK_SUPPORT,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {

        console.log(result);
        this.status=result.code;
        this.tableData = result.data;
      });
  }
}
