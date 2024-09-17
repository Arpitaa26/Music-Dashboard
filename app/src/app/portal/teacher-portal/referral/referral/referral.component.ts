import { Component, ElementRef, ViewChild } from '@angular/core';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';

@Component({
  selector: 'app-referral',
  templateUrl: './referral.component.html',
  styleUrls: ['./referral.component.scss']
})
export class ReferralComponent {
  constructor(
    private userData: UserDataService,
  ) {}

  
  userId:any = localStorage.getItem('user_id');
  @ViewChild('linkInput', { static: false }) linkInput: ElementRef | undefined;

 linkToCopy:string = 'https://thesvpacademy.com/portal/signup/'+this.userId;

 isActive = false;
 copy_txt:any;
 copyLink(){
   const textToCopy = 'https://thesvpacademy.com/portal/signup?' + 'refid=' +this.userId;

   const textarea = document.createElement('textarea');
   textarea.value = textToCopy;
   this.copy_txt = 'Link copied: '+textToCopy;
   document.body.appendChild(textarea);
   textarea.select();
   this.isActive = true;
   try {
     document.execCommand('copy');
    //  alert(`Link copied: ${textToCopy}`);
     
   } catch (err) {
    //  alert("Press Ctrl+C (or Cmd+C on Mac) to copy the link.");
   } finally {
     document.body.removeChild(textarea);
   }
  
  setTimeout( () => {
		this.isActive = false;
	}, 2500);

  
 }
 
  //refrel_api
  record_refral_user:any;
  record_status:any;
  ngOnInit(): void {
    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_REFERRAL_GET_ALL,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((res) => {
       this.record_refral_user = res.data;
       console.log(res.code)
       this.record_status=res.code;
      });
  }
}
