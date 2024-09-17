import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

export enum SelectedItem {
  Module,
  Tutorial,
}

export interface SelectedData {
   mode :  SelectedItem,
    id: number,
  }
@Injectable({
  providedIn: 'root',
})
export class ModuleTeachService {
  selectedItemTeacher = new BehaviorSubject<SelectedData>({mode : SelectedItem.Module , id: 0});

  selectedItemStudent = new BehaviorSubject<SelectedData>({mode : SelectedItem.Module , id: 0});


  constructor() {}
}
