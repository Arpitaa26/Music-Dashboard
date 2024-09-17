import { Component, OnInit } from '@angular/core';



@Component({
  selector: 'app-update-profile',
  templateUrl: './update-profile.component.html',
  styleUrls: ['./update-profile.component.scss']
})
export class UpdateProfileComponent implements OnInit {

  constructor() { }

  ngOnInit(): void {
  }

  update_register(data:any){
    console.log(data);
  }


}
