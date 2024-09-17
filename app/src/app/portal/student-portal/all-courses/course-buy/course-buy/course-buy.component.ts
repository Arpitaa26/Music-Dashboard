import { Component } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';

@Component({
  selector: 'app-course-buy',
  templateUrl: './course-buy.component.html',
  styleUrls: ['./course-buy.component.scss'],
})
export class CourseBuyComponent {
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
  apply_cuppon(apply_cuppon: any) {
    console.log(apply_cuppon.value);
    let coupon_code = { coupon_code: apply_cuppon.value.coupon_code };
    this.userData
      .callApi(
        coupon_code,
        VariableConstants.METHOD_GET,
        RequestMapper.API_COUPON_APPLY_COUPON,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        // console.log(result.data.discount);
        this.tot = this.courses_response[0].price;
        this.total_price = this.tot * apply_cuppon.value.price_qut;
        this.final_price =
          this.total_price - (this.total_price * result.data.discount) / 100;
        console.log(this.final_price);
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

// if (this.class_res.status == '200') {
//   window.open('https://thesvpacademy.com/admin/make_payment');
// } else if (this.class_res.status == '203') {
//   //console.log(this.res.status);
//   alert(this.class_res.body.message);
// } else {
//   alert(this.class_res.body.message);
// }
      });
  }
}

// 69%10= 69*10/100 =6.9 taka

// 69-6.9=
