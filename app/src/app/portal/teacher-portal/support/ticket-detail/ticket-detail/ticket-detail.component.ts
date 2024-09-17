import { Component, EventEmitter, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { DomSanitizer, SafeHtml } from '@angular/platform-browser';
import { ActivatedRoute, Router } from '@angular/router';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';

@Component({
  selector: 'app-ticket-detail',
  templateUrl: './ticket-detail.component.html',
  styleUrls: ['./ticket-detail.component.scss'],
})
export class TicketDetailComponent implements OnInit {
  form = new FormGroup({
    task_comment: new FormControl(''),
    user_id: new FormControl(''),
    task_id: new FormControl(''),
  });

  ticketDetails: any;
  newDate: any;
  replyDate: any;
  commentData: any;
  todayNumber: number = Date.now();
  user_id: any = 0;
  ticketId: any;
  task_id: number = 0;
  u_status: any;
  constructor(
    private route: ActivatedRoute,
    private userData: UserDataService,
    private sanitizer: DomSanitizer
  ) {
    this.ticketId = this.route.snapshot.params['ticketId'];
  }
  // replyData: ReplyData[] = MsgReplyModel.returnMethod;
  ngOnInit(): void {
    // this.route.paramMap.subscribe(params => {
    //   let ticketId = params.get('ticketId');

    this.user_id = localStorage.getItem('user_id');

    this.userData
      .callApi(
        { task_id: this.ticketId },
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

        console.log(this.ticketDetails);
      });
    // })
    // this.userData
    //   .callApi(
    //     { task_id: this.ticketId },
    //     VariableConstants.METHOD_GET,
    //     RequestMapper.API_TASK_COMMENT,
    //     VariableConstants.ACCESS_PRIVATE
    //   )
    //   .subscribe((result: any) => {
    //     console.log(result.data);
    //     this.commentData = result.data;
    //     // let ticketDat = result.data[0];
    //     // this.newDate = ticketDat.created_on;
    //     // // this.todayISOString = newDate.toISOString();
    //     // // console.log(newDate);
    //     // this.ticketDetails = result.data;
    //     this.task_id = result.data[0].task_id;
    //   });
  }
  // removeElement(html: any, elementTagName: string): SafeHtml {
  //   const div = document.createElement('p');
  //   div.innerHTML = html;

  //   const elementsToRemove = div.querySelectorAll(elementTagName);
  //   elementsToRemove.forEach(element => element.remove());

  //   const sanitizedHtml = this.sanitizer.bypassSecurityTrustHtml(div.innerHTML);
  //   return sanitizedHtml;
  // }
  submitForm() {
    // alert(task_id);
    let task_id_str = this.task_id.toString();
    let user_id_str = this.user_id.toString();
    this.form.controls['user_id'].setValue(user_id_str);
    this.form.controls['task_id'].setValue(task_id_str);
    let inpData = this.form.value;
    // location.reload();

    this.userData
      .callApi(
        inpData,
        VariableConstants.METHOD_POST,
        RequestMapper.API_POST_COMMENT,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        // this.courseLevel = result.data;
        console.log(result);
      });
  }
}
