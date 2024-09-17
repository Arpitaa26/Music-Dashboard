import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';

@Component({
  selector: 'app-bar-group',
  templateUrl: './bar-group.component.html',
  styleUrls: ['./bar-group.component.scss'],
})
export class BarGroupComponent {


 
  @Input() classNum: number = 0;
  
}