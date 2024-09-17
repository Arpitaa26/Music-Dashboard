import { Component, OnInit } from '@angular/core';
import { RequestMapper } from 'src/app/request-mapper';
import { Menu } from 'src/app/sidebar/sidebarinterface';

@Component({
  selector: 'app-student-portal',
  templateUrl: './student-portal.component.html',
  styleUrls: ['./student-portal.component.scss'],
})
export class StudentPortalComponent implements OnInit {
  constructor() {}

  menuStudent: Menu[] = [
    {
      svg: './assets/img/dashboard-icon.svg',
      icon: '',
      text: 'Dashboard',
      id: 'Dashboard0',
      link: RequestMapper.STUDENTS_DASHBOARD,
    },
    {
      svg: './assets/img/class-details-icon.svg',
      icon: '',
      text: 'Class Details',
      id: 'class_details',
      link: RequestMapper.STUDENTS_CLASS_DETAILS,
    },
    {
      svg: './assets/img/assignment-icon.svg',
      icon: 'fa-file-text',
      text: 'Assignments',
      id: 'Assignments',
      link: RequestMapper.STUDENTS_ASSIGNMENTS,
    },
    // {
    //   icon: 'fa-regular fa-newspaper',
    //   text: 'Dashboard',
    //   id: 'Dashboard3',
    //   link: 'asdaasasad',
    // },
    {
     svg:'./assets/img/course-info-icon.svg',
      icon: 'fas fa-info-circle',
      text: 'Course Info',
      id: 'course_info',
      link: RequestMapper.COURSE_INFO,
    },
    {
       svg:'./assets/img/Group.svg',
      icon: 'fas fa-folder',
      text: 'Performance Report',
      id: 'performance_report',
      link: RequestMapper.PERFORMANCE_REPORT,
    },
    {
      svg: './assets/img/referral-icon.svg',
      icon: 'fas fa-repeat',
      text: 'Referral',
      id: 'teacher_referral',
      link: RequestMapper.TEACHER_REFERRAL,
    },
    {
      svg: './assets/img/support-icon.svg',
      icon: 'fas fa-headset',
      text: 'Support',
      id: 'support_portal',
      link: RequestMapper.SUPPORT,
    },
    // {
    //   svg: './assets/img/dashboard-icon.svg',
    //   icon: 'fas fa-headset',
    //   text: 'All Courses',
    //   id: 'all_courses',
    //   link: RequestMapper.ALL_COURSES,
    // },
  ];
  nav_status_data = false;
  nav_status(data: any) {
    this.nav_status_data = data;
    console.log(this.nav_status_data);
  }
  ngOnInit(): void {}
}
