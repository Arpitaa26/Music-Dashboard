
import { Component, EventEmitter,Input , Output } from '@angular/core';
@Component({
  selector: 'danger',
  templateUrl: './danger.component.html',
  styleUrls: ['./danger.component.scss']
})
export class DangerComponent {
  @Input() msg: string | undefined;
}
