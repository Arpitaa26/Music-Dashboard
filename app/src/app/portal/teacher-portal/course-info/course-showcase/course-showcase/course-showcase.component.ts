import { Component, HostListener, Input, OnInit } from '@angular/core';
import { AccordianModel } from '../model/accordianModel';
import { OwlOptions } from 'ngx-owl-carousel-o';
import { CarouselModel } from '../model/carouselModel';
import { Router, ActivatedRoute } from '@angular/router';

import { VariableConstants } from 'src/app/variable-contants';
import { UserDataService } from 'src/app/services/user-data.service';
import { RequestMapper } from 'src/app/request-mapper';
import { ModuleListGetApi } from 'src/app/ConstantInterface/moduleListGet';
import {
  TutorialGetApi,
  TutorialGetApiObj,
} from 'src/app/ConstantInterface/tutorialApiInterface';
import { ModuleListLevelApi } from 'src/app/ConstantInterface/moduleListLevel';

import { CarouselInterface } from '../interface/carouselInterface';
import { repeat } from 'rxjs';
import {
  ModuleTeachService,
  SelectedData,
  SelectedItem,
} from '../../services/module-teach.service';
@Component({
  selector: 'app-course-showcase',
  templateUrl: './course-showcase.component.html',
  styleUrls: ['./course-showcase.component.scss'],
})
export class CourseShowcaseComponent implements OnInit {
  imgData = CarouselModel.returnMethod;
  data = AccordianModel.returnMethod;
  moduleId: number = 0;
  moduleData: any = [];
  tutorialData: any = [];
  tutorialFixedData: any = [];
  tutorialList: any = [];
  tutorialDataDesc: string = '';
  ImageFiles: any = [];
  modName: string = '';
  showOverview: boolean = true;
  question: boolean = false;
  public isActive: boolean = true;
  loading: boolean = true;
  imageObject: any = [];
  public toggleId: number = 0;
  //

  activeTab: number = 1; // Set the default active tab

  status: any = '1';

  showTabContent(tabNumber: number): void {
    this.activeTab = tabNumber;
  }

  selectedItem: SelectedItem = SelectedItem.Tutorial;
  allSelected = SelectedItem;
  //

  constructor(
    private route: Router,
    private aroute: ActivatedRoute,
    private userData: UserDataService,
    private moduleTeach: ModuleTeachService
  ) {
    // this.moduleTeach.selectedItem.subscribe((data: SelectedData) => {
    //   this.selectedItem = data.mode;
    // });
  }

  // owl-Carousel
  customOptions: OwlOptions = {
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

  // Accordian
  isActiveData: boolean = true;
  url_mod_id: any;
  toggleAccordian(event: any, moduleId: number) {
    // this.moduleTeach.selectedItem.next(SelectedItem.Module)
    console.log(event);
    // let courseId = this.aroute.snapshot.paramMap.get('id'); // this.route.url.split('/').slice(2)[3];
    // let levelId = this.aroute.snapshot.paramMap.get('levelId'); //this.route.url.split('/').slice(-1)[0];
    // let moduleUrlId = this.aroute.snapshot.paramMap.get('moduleId'); //this.route.url.split('/').slice(2)[6];
    var element = event.target || event.srcElement || event.currentTarget;
    var acc = document.getElementsByClassName('accordion');
    this.isActiveData = false;
    // element.classList.toggle('activeggg');
    var className = document.getElementsByClassName('panel');
    let accId = moduleId;
    this.toggleId = moduleId;
    this.tutorial_User_data = this.tutorialList;
    console.log('Test:-' + this.tutorial_User_data);

    // Tutorial Api

    this.tutorialData = this.tutorialFixedData;
    this.ImageFiles = null;
    var panel = element.nextElementSibling;
  }
  // if (panel.style.maxHeight) {
  //   console.log(panel.style.maxHeight);
  // } else {
  //   panel.style.maxHeight = panel.scrollHeight + '63px';
  // }

  bannerHeight: any;
  idTutorial: any;
  tutorial_id: number = 0;
  visibelBanner: boolean = false;
  tutorialClick(tutorialId: number) {
    this.moduleTeach.selectedItemTeacher.next({mode : SelectedItem.Tutorial , id: tutorialId});
    this.tutorial_id = tutorialId;
    let tutoId = tutorialId;
    this.idTutorial = tutoId;
    this.visibelBanner = true;

    this.userData
      .callApi(
        { tutorial_id: tutoId },
        VariableConstants.METHOD_GET,
        RequestMapper.API_TUTORIAL_GALLERY_GET,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.bannerHeight = '90';
        this.ImageFiles = result.data;
        console.log(this.ImageFiles);

        for (let data of this.ImageFiles) {
          this.imageObject.push({
            image: 'https://thesvpacademy.com/admin/file/open/' + data.slug,
            thumbImage: 'https://thesvpacademy.com/admin/file/open/' + data.slug,
          });
        }
      });

    this.tutorialData = this.tutorialList;
  }

  // Scroll-Property on SideBarSec
  @HostListener('window:scroll', [])
  onWindowScroll() {
    const scrollOffset =
      window.pageYOffset ||
      document.documentElement.scrollTop ||
      document.body.scrollTop ||
      0;
    const box = document.getElementsByClassName('sideBarSec')[0];
    if (scrollOffset >= 50) {
      if (box != null) {
        box.classList.add('sideBarSecOnScroll');
      }
    } else {
      if (box != null) {
        box.classList.remove('sideBarSecOnScroll');
      }
    }
  }
  tutorial_User_data: any = [];
  all_match_module: any = [];
  course_history: any = [];

  moduleUrlId: number = 0;

  ngOnInit(): void {
    // COURSE HISTORY GET ALL
    // alert("test")
    // this.userData
    // .callApi(
    //   {},
    //   VariableConstants.METHOD_GET,
    //   RequestMapper.API_COURSE_HISTORY_GET_ALL,
    //   VariableConstants.ACCESS_PRIVATE
    // )
    // .subscribe((result) => {
    //  this.course_history = result.data;
    // console.log(this.course_history)
    // });

    let user_id = this.aroute.snapshot.paramMap.get('userId');
    let batch_id = this.aroute.snapshot.paramMap.get('batchId');
    let courseId = this.aroute.snapshot.paramMap.get('id'); // this.route.url.split('/').slice(2)[3];
    let levelId = this.aroute.snapshot.paramMap.get('levelId'); //this.route.url.split('/').slice(-1)[0];
    this.moduleUrlId = Number(this.aroute.snapshot.paramMap.get('moduleId')); //this.route.url.split('/').slice(2)[6];
    this.toggleId = this.moduleUrlId;
    this.url_mod_id = this.moduleUrlId;

    this.url_mod_id = this.moduleUrlId;
    console.log(levelId);
    console.log(this.moduleUrlId);
    this.userData
      .callApi(
        { user_id, batch_id, course_id: courseId, course_level_id: levelId },
        VariableConstants.METHOD_GET,
        RequestMapper.API_MODULE_GET,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: ModuleListGetApi) => {
        console.log(result.code);

        console.log(result);
        this.moduleData = result.data;
        this.tutorialFixedData = result.data;
        this.tutorialData = result.data;
        this.modName = this.moduleData[0].course_name;
        this.moduleId = this.moduleData[0].id;
        this.loading = false;
        // alert(this.moduleId);
        console.log(result);
        // for (let i = 0; i < result.data.length; i++) {
        //   console.log("test:-"+result.data[i].id)
        //   if(result.data[i].id==this.url_mod_id){
        //   this.isActive = true;
        //   console.log(result.data[i].id,this.url_mod_id);
        // }else{
        //   this.isActive = false;
        //   console.log(result.data[i].id,this.url_mod_id);
        // }
        // }
      });

    this.userData
      .callApi(
        { user_id, batch_id, course_id: courseId, course_level_id: levelId },
        VariableConstants.METHOD_GET,
        RequestMapper.API_TUTORIAL_GET,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: TutorialGetApi) => {
        this.tutorialList = [];
        result.data.forEach((eachTutorial) => {
          if (!this.tutorialList[eachTutorial.module_id])
            this.tutorialList[eachTutorial.module_id] = [];
          this.tutorialList[eachTutorial.module_id].push(eachTutorial);
          console.log(JSON.stringify(this.tutorialList));
        });
      });

    setTimeout(() => {
      // <<<---using ()=> syntax
      // THIS IS Repeated API======================================
      // this.userData
      //   .callApi(
      //     { module_id: this.moduleId },
      //     VariableConstants.METHOD_GET,
      //     RequestMapper.API_TUTORIAL_GET,
      //     VariableConstants.ACCESS_PRIVATE
      //   )
      //   .subscribe((result: TutorialGetApi) => {
      //     this.tutorialList = result.data;      //     console.log(this.tutorialList)
      //     this.loading = false;
      //   });
      // THIS IS Repeated API======================================
    }, 1000);
  }

  // res: any = [];
  // startclass() {
  //   let class_id = localStorage.getItem('ClassId');
  //   this.userData
  //     .callApi(
  //       {},
  //       VariableConstants.METHOD_POST,
  //       RequestMapper.API_COURSE_START_COMPLETE + '/' + class_id,
  //       VariableConstants.ACCESS_PRIVATE
  //     )
  //     .subscribe((result: any) => {
  //       this.res = result;
  //     });
  // }

  // endclass() {
  //   let class_id = localStorage.getItem('ClassId');
  //   this.userData
  //     .callApi(
  //       {},
  //       VariableConstants.METHOD_POST,
  //       RequestMapper.API_COURSE_START_COMPLETE + '/' + class_id,
  //       VariableConstants.ACCESS_PRIVATE
  //     )
  //     .subscribe((result: any) => {
  //       this.res = result;
  //     });
  // }

  res: any = [];
  CompleteTutorial(data: TutorialGetApiObj) {
    const req = {
      tutorial_id: data.id,
      module_id: data.module_id,
      flag: 'lock',
    };
    this.userData
      .callApi(
        req,
        VariableConstants.METHOD_POST,
        RequestMapper.API_COURSE_START_COMPLETE + '/' + data.batch_id,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.res = result;
        this.ngOnInit();
      });
  }

  popupVisible = false;
  popupImageUrl = '';
  hide_comp: boolean = false;
  openImagePopup(status: boolean) {
    this.hide_comp = status;
    this.popupVisible = status;
    // this.popupImageUrl = img;

    console.log(this.ImageFiles);

    console.log(this.popupImageUrl);
  }
}
