// import { Component, OnInit } from '@angular/core';
import { Component, OnInit, Output, EventEmitter } from '@angular/core';
import { Navs } from '../model/navs';
import { Nav } from '../interface/nav';
import { NavDataTransferService } from 'src/app/service/nav-data-transfer.service';
import { RequestMapper } from 'src/app/request-mapper';
@Component({
  selector: 'app-nav',
  templateUrl: './nav.component.html',
  styleUrls: ['./nav.component.scss'],
})
export class NavComponent implements OnInit {
  @Output() navDataPassforOpenOrClose = new EventEmitter<boolean>();
  userType: string = '';
  constructor(private navComunicationService: NavDataTransferService) {}
  nav_toggle_status = false;
  open_close_data() {
    
    this.navDataPassforOpenOrClose.emit(
      this.nav_toggle_status
        ? (this.nav_toggle_status = false)
        : (this.nav_toggle_status = true)
    );
    this.more_menu = false;
  }
  more_menu = false;
  openCloseMoreMenu() {
    this.navDataPassforOpenOrClose.emit(false);
    this.nav_toggle_status = false;
    this.more_menu ? (this.more_menu = false) : (this.more_menu = true);
  }
  close_more_menu() {
    this.more_menu ? (this.more_menu = false) : (this.more_menu = true);
  }
  topNavs: Nav[] = [];
  subscribe: any;
  profilePicObj: Nav = {
    name: 'Profile',
    link: RequestMapper.PROFILE,
    id: 'profile',
    type: 'image',
    image: '',
  };
  student:boolean=false
  teacher:boolean=false
  ngOnInit(): void {


    let type:any=localStorage.getItem('user_type')
    if (localStorage.getItem('user_first_name')) {
      this.userType = localStorage.getItem('user_first_name')!;
    }
    if(type=='STUDENT'){
      this.student = true;
    }else if(type=='TEACHER'){
      this.teacher = true;
    }
    this.topNavs = Navs.navMethod;
    console.log(Navs.navMethod);
    this.subscribe = this.navComunicationService.navCloseListner.subscribe(
      (res) => {
        if (!res) {
          this.navDataPassforOpenOrClose.emit(false);
          this.nav_toggle_status = false;
        }
      }
    );
    this.profilePicObj = Navs.navMethod.find(
      (element: Nav) => element.type === 'image'
    )!;
  }

  ngOnDestroy(): void {
    this.subscribe ? (this.subscribe = undefined) : this.subscribe;
  }
}
