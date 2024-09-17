import { Component, EventEmitter,Input , Output } from '@angular/core';

@Component({
  selector: 'sucess',
  templateUrl: './sucess.component.html',
  styleUrls: ['./sucess.component.scss']
})
export class SucessComponent {
  @Input() msg: string | undefined;
}
