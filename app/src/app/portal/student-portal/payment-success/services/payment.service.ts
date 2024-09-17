import { Injectable } from '@angular/core';
import { UserDataService } from 'src/app/services/user-data.service';
import { Observable } from 'rxjs';
import { VariableConstants } from 'src/app/variable-contants';
import { RequestMapper } from 'src/app/request-mapper';

export interface IPaymentStatusResp {
    code: number; data: PaymentStatus; message: string 
}
export enum PaymentStatus {
    PAID = 'paid',
    PENDING = 'pending',
  }
@Injectable({
    providedIn: 'root',
  })
  export class PaymentApiService {
    constructor(private userData: UserDataService) {}
  
    getPaymentStatus(reference_id:string):Observable<IPaymentStatusResp> {
      return this.userData.callApi(
        {reference_id},
        VariableConstants.METHOD_POST,
        RequestMapper.API_PAYMENT_STATUS,
        VariableConstants.ACCESS_PUBLIC
      );
    }

}