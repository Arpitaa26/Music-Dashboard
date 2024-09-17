import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';

@Component({
  selector: 'app-course-buys',
  templateUrl: './course-buy.component.html',
  styleUrls: ['./course-buy.component.scss'],
})
export class CourseBuysComponent {
  @Output() messageEvent = new EventEmitter<string>();
  courses_id: any;
  lavel: any;
  type: any;
  courses_response: any;
  constructor(
    private userData: UserDataService,
    private activeRout: ActivatedRoute
  ) {}
  data: any;
  ngOnInit(): void {
    this.base_url = 'https://thesvpacademy.com/admin/file/open/';
    this.data = this.activeRout.snapshot.paramMap.get('data');

    this.type = this.activeRout.snapshot.params['type'];
    this.courses_id = this.activeRout.snapshot.params['cId'];
    this.lavel = this.activeRout.snapshot.params['lavel'];

    let ttype = localStorage.getItem('type');
    //alert(this.id)
    console.log(this.data);

    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_COURSE_ALL +
          '?course_id=' +
          this.activeRout.snapshot.params['cId'] +
          '&course_level_id=' +
          this.activeRout.snapshot.params['lavel'] +
          '&session_type_id=' +
          this.activeRout.snapshot.params['type'],
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result) => {
        this.courses_response = result.data;
        console.log('===============================================');
        console.log(this.courses_response);

        console.log(this.courses_response[0].price);
      });

    window.onpopstate = () => {
      // Clear the specific localStorage data when the back button is clicked
      localStorage.removeItem('type');
      localStorage.removeItem('courses_id');
      localStorage.removeItem('lavel');
    };
  }

  res: any = [];

  enroll_class(data: any) {
    console.log(data);
    this.userData
      .callApi(
        data,
        VariableConstants.METHOD_POST,
        RequestMapper.API_COURSE_ENROLL,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.res = result;
        // console.log(this.res)

        // if (result.status == '200') {
        //   alert('course enrolled successfully');
        // } else if (result.status == '203') {
        //   alert('Courses is All ready Enroll');
        // }
      });
  }
  selectedOption: any = '';
  total: any;
  onSelectChange(event: Event) {
    // Access the selected value from the event
    const selectedValue = (event.target as HTMLSelectElement).value;

    // Update the selectedOption property
    this.selectedOption = selectedValue;
    this.total = this.courses_response[0].price * this.selectedOption;
    console.log('Selected option:', this.total);
    // Perform any other actions you want based on the selected value
  }
  //price_qut
  all_ok: boolean = false;
  tot: any;
  total_price: any;
  final_price: any;
  cuppon_codes:any;
  result_message:any;
  ress:any;
  msg: any = '';
  msgs: any;
  rc_status:boolean = false;
  rc_false_status:boolean =false;
  discount_type:any;
  all_msgs: any;
  //message display
  apply_cuppon(apply_cuppon: any) {
    this.cuppon_codes = apply_cuppon.value.coupon_code;
    console.log(this.cuppon_codes);
    let coupon_code = { coupon_code: apply_cuppon.value.coupon_code };
    this.userData
      .callApi(
        coupon_code,
        VariableConstants.METHOD_GET,
        RequestMapper.API_COUPON_APPLY_COUPON,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
         console.log(result);
        this.ress=result.code;
        this.result_message = result.message;


        setTimeout(() => {
          if (result.code == '200') {
            this.rc_status=true;
            this.all_msgs = result.message;
            this.messageEvent.emit(this.all_msgs);
          //  alert(this.res.body.message);
            
          } else {
            // alert(result.message);
            this.all_msgs = result.message;
            this.rc_false_status = true;
            this.messageEvent.emit(this.all_msgs);
          }
          // <<<---using ()=> syntax
          //    this.msgs = result.message;
          // this.msg = result.message;
          setTimeout(() => {
            this.all_msgs = ''; 
           this.rc_status=false;
           this.rc_false_status = false;
           // window.location.reload();
        }, 3000);
        }, 3000);







        this.discount_type= result.data.type;
        if(this.discount_type=='percentage'){
          this.tot = this.courses_response[0].price;
          this.total_price = this.tot * apply_cuppon.value.price_qut;
          this.final_price =
            this.total_price - (this.total_price * result.data.discount) / 100;
        }else if(this.discount_type=='number'){
          this.tot = this.courses_response[0].price;
          this.total_price = this.tot * this.selectedOption;
          this.final_price=this.total_price-result.data.discount
        
        }
        
        //console.log(this.final_price);
        console.log("Check Messages")
        // alert(result.message)
        setTimeout(() => {
          if (result.code == '200') {
            this.rc_status=true;
            this.all_msgs = result.message;
            this.messageEvent.emit(this.all_msgs);
          //  alert(this.res.body.message);
            
          } else {
            // alert(result.message);
            this.all_msgs = result.message;
            this.rc_false_status = true;
            this.messageEvent.emit(this.all_msgs);
          }
          // <<<---using ()=> syntax
          //    this.msgs = result.message;
          // this.msg = result.message;
          setTimeout(() => {
            this.all_msgs = ''; 
           this.rc_status=false;
           this.rc_false_status = false;
           // window.location.reload();
        }, 3000);
        }, 3000);



        // if(result.code=='203'){
        //   alert(result.message)
        // }
        if (result.data.coupon_code == true) {
          console.log(
            this.courses_response[0].price * apply_cuppon.value.price_qut
          );
        } else {
          console.log('Wrong Price');
        }
      });
    // console.log(apply_cuppon.value)
  }

  class_res: any;
status_not_found:any;
msgss:any;

st_msg:any;
status_sucess:boolean = false;
status_error:boolean = false;
base_url:any;
  course_buy_api(data: any) {
    console.log(data);
    this.userData
      .callApi(
        data,
        VariableConstants.METHOD_POST,
        RequestMapper.API_COURSE_BUY,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.class_res = result;
        console.log( this.class_res)


        // window.open('https://thesvpacademy.com/admin/course_enrollment/make_payment');
this.status_not_found = this.class_res.status;
this.msgss = this.class_res.body.message;
        //alert(this.class_res.body.message);


        setTimeout(() => {
     
          if (result.body.code == 200) {

            this.st_msg =  this.class_res.body.message;

            this.status_sucess = true;
            // status_error:boolean = false;
           // this.messageEvent.emit(this.st_msg);
          } else if (result.body.code == 203) {
            //console.log(this.res.status);
            this.status_error = true;
            this.st_msg =  this.class_res.body.message;
            this.messageEvent.emit(this.st_msg);
          } else {
            this.status_error = true;
            this.st_msg =  this.class_res.body.message;
            this.messageEvent.emit(this.st_msg);
          }



        
   
        setTimeout(() => {
        //  debugger
        this.status_error = false;
            this.status_sucess = false;
           
          this.st_msg = '';
          // debugger 
      
      }, 3000);
        })


        if (this.class_res.status == '200') {
          window.location=this.class_res.body.data;
        } else if (this.class_res.status == '203') {
          //console.log(this.res.status);
          //alert(this.class_res.body.message);
        } else {
          //alert(this.class_res.body.message);
        }
      });
  }
}
