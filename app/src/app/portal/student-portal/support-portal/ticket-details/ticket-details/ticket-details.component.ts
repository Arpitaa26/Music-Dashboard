import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import { ReplyData } from '../interface/msgReply_interface';
import { MsgReplyModel } from '../Model/msgReply_model';

@Component({
  selector: 'app-ticket-details',
  templateUrl: './ticket-details.component.html',
  styleUrls: ['./ticket-details.component.scss'],
})
export class TicketDetailsComponent implements OnInit {
  ticketDetails: any;
  newDate: any;
  replyDate: any;
  todayNumber: number = Date.now();

  constructor(private route: Router, private userData: UserDataService) {}
  // replyData: ReplyData[] = MsgReplyModel.returnMethod;
  ngOnInit(): void {
    let ticketId = this.route.url.split('/').slice(-1)[0];
    console.log(ticketId);

    this.userData
      .callApi(
        { task_id: ticketId },
        VariableConstants.METHOD_GET,
        RequestMapper.API_TASK_SUPPORT,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        // console.log(result.data);
        // let ticketDat = result.data[0];
        // this.newDate = ticketDat.created_on;
        // this.todayISOString = newDate.toISOString();
        // console.log(newDate);
        this.ticketDetails = result.data;
        // this.user_id = result.data[0].user_id;
        // console.log(this.user_id);
      });
  }
}
