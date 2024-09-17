import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { Menu } from '../sidebarinterface';
import { RequestMapper } from 'src/app/request-mapper';
import { NavDataTransferService } from 'src/app/service/nav-data-transfer.service';
@Component({
  selector: 'app-sidebar',
  templateUrl: './sidebar.component.html',
  styleUrls: ['./sidebar.component.scss'],
})
export class SidebarComponent implements OnInit {
 
  showTooltip = false;
  @Input() menu: Menu[] = [];
  constructor(private navComunicationService: NavDataTransferService) {}
  @Output() navDataPassforOpenOrClose = new EventEmitter<boolean>();
  nav_toggle_status = false;
  handel_close_data() {
  
    this.navDataPassforOpenOrClose.emit(
      this.nav_toggle_status
        ? (this.nav_toggle_status = false)
        : (this.nav_toggle_status = true)
    )
    this.more_menu = false;
  }
  more_menu = false;
  menu_ind = 0;
  menu_select(menu_obj: Menu, i: number) {
    // console.log(menu_obj);
    // this.menu_ind = i;
    if (window.screen.width < 999) {
      this.close_mob_nav();
    }
  }
  close_mob_nav() {
    this.navComunicationService.methNavCloseListner(false);
  }
  ngOnInit(): void {
    
  }
}
