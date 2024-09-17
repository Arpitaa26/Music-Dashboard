import { Component } from '@angular/core';
import { Input } from '@angular/core';
import { OwlOptions } from 'ngx-owl-carousel-o';
import { CarouselModel } from '../model/carouselModel';
@Component({
  selector: 'app-image-popup',
  templateUrl: './image-popup.component.html',
  styleUrls: ['./image-popup.component.scss']
})
export class ImagePopupComponent {
  @Input() popupVisible = false;
  @Input() ImageFiles = '';
  @Input() popupImageUrl='';
@Input() hide_comp=true;
  closePopup() {
    this.popupVisible = false;
    this.hide_comp=false;
  }
   // owl-Carousel
   popup_img_Options: OwlOptions = {
    loop: true,
    autoplay: false,
    autoWidth: true,
    mouseDrag: true,
    touchDrag: false,
    pullDrag: false,
    dots: true,
    navSpeed: 300,
    navText: [
      '<i class="fa-solid fa-angle-left"></i>',
      '<i class="fa-solid fa-angle-right"></i>',
    ],
    responsive: {
      0: {
        items: 1,
      },
      400: {
        items: 2,
      },
      740: {
        items: 1,
      },
      940: {
        items: 1,
      },
    },
    nav: true,
  };
  



  imageObject: any = [];
  ngOnInit(): void {


  for (let data of this.ImageFiles) {
    this.imageObject.push({
      // image: 'https://thesvpacademy.com/admin/file/open/' + data.slug,
      // thumbImage: 'https://thesvpacademy.com/admin/file/open/' + data.slug,
    });
  }
}
}
