import { Injectable } from '@angular/core';
import { Subject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class NavDataTransferService {

  constructor() { }
  navCloseListner = new Subject();
  methNavCloseListner(data:boolean){
    this.navCloseListner.next(data)
  }
}
