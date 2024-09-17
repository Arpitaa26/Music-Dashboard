import { Component, OnInit } from '@angular/core';
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
  descending_data:any;
  status:any;
  constructor(private userData: UserDataService) {}
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
  // getSortedKeys(obj: { [key: string]: any }, order: 'asc' | 'desc'): string[] {
  //   const keys = Object.keys(obj);

  //   return order === 'asc'
  //     ? keys.sort((a, b) => a.localeCompare(b))
  //     : keys.sort((a, b) => b.localeCompare(a));
  // }
}
