import { Component, EventEmitter, Output, Input } from '@angular/core';

@Component({
  selector: 'app-button',
  templateUrl: './button.component.html',
  styleUrls: ['./button.component.scss']
})
export class ButtonComponent {
  @Input() category: string | undefined;
  @Output() categorySelected = new EventEmitter<string>();
  @Input() isActive: boolean = false;
  selectCategory() {
    this.categorySelected.emit(this.category);
  }
}
