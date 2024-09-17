import { Component, OnInit } from '@angular/core';
import { RequestMapper } from 'src/app/request-mapper';
import { Menu } from 'src/app/sidebar/sidebarinterface';

@Component({
  selector: 'app-teacherportal',
  templateUrl: './teacher-portal.component.html',
  styleUrls: ['./teacher-portal.component.scss'],
})
export class TeacherportalComponent implements OnInit {
  constructor() {}
  menuTeacher: Menu[] = [
    {
      svg:'./assets/img/dashboard-icon.svg',
      icon: '',
      text: 'Dashboard',
      id: 'Dashboard0',
      link: RequestMapper.STUDENTS_DASHBOARD,
    },
    {
      svg:'./assets/img/class-details-icon.svg',
      icon: 'fa fa-music',
      text: 'Class Details',
      id: 'class_details',
      link: RequestMapper.STUDENTS_CLASS_DETAILS,
    },
    {
      svg:'./assets/img/assignment-icon.svg',
      icon: 'fa-file-text',
      text: 'Assignments',
      id: 'Assignments',
      link: RequestMapper.STUDENTS_ASSIGNMENTS,
    },

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
    // {
    //   icon: 'fas fa-circle-user',
    //   text: 'Teacher Profile',
    //   id: 'teacher_profile',
    //   link: RequestMapper.TEACHER_PROFILE,
    // },
    {
      svg:'./assets/img/referral-icon.svg',
      icon: 'fas fa-repeat',
      text: 'Referral',
      id: 'teacher_referral',
      link: RequestMapper.TEACHER_REFERRAL,
    },
    {
      svg:'./assets/img/support-icon.svg',
      icon: 'fas fa-headset',
      text: 'Support',
      id: 'support_portal',
      link: RequestMapper.SUPPORT,
    }
    
    //  {
    //   svg:'./assets/img/class-details-icon.svg',
    //   icon: 'fas fa-headset',
    //   text: 'Availability',
    //   id: 'teacher_availability',
    //   link:RequestMapper.TEACHER_AVAILABILITY,
    // },
  ];
  nav_status_data = false;
  nav_status(data: any) {
    this.nav_status_data = data;
    console.log(this.nav_status_data);
  }
  ngOnInit(): void {
  
  }
}
