import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { RequestMapper } from 'src/app/request-mapper';

@Component({
  selector: 'app-logout',
  templateUrl: './logout.component.html',
  styleUrls: ['./logout.component.scss']
})
export class LogoutComponent implements OnInit {

  constructor(
    private router:Router
  ) { }

  ngOnInit(): void {
    localStorage.clear();
    this.router.navigate([RequestMapper.LOGIN]);

  }

}
