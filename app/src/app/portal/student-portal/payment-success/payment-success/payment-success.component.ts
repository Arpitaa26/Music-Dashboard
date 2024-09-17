import { Component, OnDestroy, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import { interval, Subscription, takeUntil, timer } from 'rxjs';
import {
  IPaymentStatusResp,
  PaymentApiService,
  PaymentStatus,
} from '../services/payment.service';
import { HttpResponse } from '@angular/common/http';

@Component({
  selector: 'app-payment-success',
  templateUrl: './payment-success.component.html',
  styleUrls: ['./payment-success.component.scss'],
})
export class PaymentSuccessComponent implements OnInit, OnDestroy {
  paymentStatusTypes = PaymentStatus;
  isPaymentStatus!: PaymentStatus;
  refrenceId!: { reference_id: string };
  message: any;
  timerSub!: Subscription;
  isComplete: boolean = false;
  constructor(
    private route: ActivatedRoute,
    private paymentApiService: PaymentApiService
  ) {}
  intervalId: any;
  ngOnInit(): void {
    this.route.params.subscribe((params) => {
      const reference_id = params['refId']; // Access the 'id' parameter
      // Now you can use this.id to fetch corresponding data or perform any other actions
      this.timerSub = timer(0, 10000).subscribe(() => {
        this.getPaymentStatus(reference_id);
      });
    });
  }

  getPaymentStatus(reference_id: string): void {
    this.paymentApiService
      .getPaymentStatus(reference_id)
      .subscribe((res :any) => {
        const response = res.body as IPaymentStatusResp;
        this.isPaymentStatus = response.data as PaymentStatus;
        this.message = response.message;
        switch (this.isPaymentStatus) {
          case PaymentStatus.PENDING:
            break;

          case PaymentStatus.PAID:
            this.isComplete = true;
            this.timerSub.unsubscribe();
            // Payment Done
            break;
        }
      });
  }

  ngOnDestroy(): void {
    this.timerSub.unsubscribe();
  }
}
