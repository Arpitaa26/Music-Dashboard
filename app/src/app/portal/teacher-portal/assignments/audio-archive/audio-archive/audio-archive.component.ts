import { ChangeDetectorRef, Component, Input, OnInit } from '@angular/core';

import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import { RequestMapper } from 'src/app/request-mapper';
import { PerformanceReport } from 'src/app/portal/student-portal/assignments/performance-report/model/performance-report';
import { CourseLevelInterface } from 'src/app/portal/student-portal/assignments/performance-report/interface/courseLevelInterface';
import { CommomServiceService } from 'src/app/services/commom-service.service';
import {
  AudioArchiveInterface,
  IAudioArchiveResp,
} from './interfaces/audio-archive.interface';
import { FormArray, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { BehaviorSubject, combineLatest, map, switchMap, tap } from 'rxjs';
@Component({
  selector: 'app-audio-archive',
  templateUrl: './audio-archive.component.html',
  styleUrls: ['./audio-archive.component.scss'],
})
export class AudioArchiveComponent implements OnInit {
  submitFeedbackBeh$ = new BehaviorSubject<boolean>(false);
  allStudentsInfo: any = [];
  studentId: any = [];
  abhyasAudioArchiveInterface: AudioArchiveInterface[]|undefined = [];
  userdataservice: any;
  messge_result: any;
  toDisplay: boolean = false;
  @Input('studentId') public data: any = [];
  userId: any;
  initialId: any;
  feedback: any;
  myForm: FormGroup;
  audioItemForm: FormGroup;
  msgg:any;
  audio_sucess:boolean=false;
  audio_danger:boolean=false;
  constructor(
    private userData: UserDataService,
    private commonService: CommomServiceService,
    private formBuilder: FormBuilder,
    private cdr: ChangeDetectorRef
  ) {
    this.myForm = this.formBuilder.group({
      //  feedback: [''],
    });
    this.audioItemForm = this.formBuilder.group({
      listItems: this.formBuilder.array([], Validators.required),
    });

    combineLatest([
      this.commonService.assignmentStudentId,
      this.submitFeedbackBeh$,
    ])
      .pipe(
        map(([data]) => {
          this.abhyasAudioArchiveInterface = [];
          this.audioItemLists.clear();
          const { batch_id, user_id } = data;
          this.userData
            .callApi(
              {},
              VariableConstants.METHOD_GET,
              RequestMapper.API_AUDIO_ARCHIVE_GET_ALL + '&user_id=' + user_id,
              VariableConstants.ACCESS_PRIVATE
            )
            .subscribe((result: IAudioArchiveResp) => {
              console.log(result.message)
              this.msgg=result.message;

              this.abhyasAudioArchiveInterface = result.data;
              this.abhyasAudioArchiveInterface.map((el) =>
                this.addAudioItem(el)
              );
         



              this.allStatus = result.code;

              setTimeout(() => {
               
                if (result.code == '200') {
                 this.msgg='';
  
                } else{
                  this.msgg=result.message;
                  this.messge_result = 'No Audio uploaded yet';
                }
                if(this.allStatus == '203'){
                
                  this.msgg=result.message;
                }
                setTimeout(() => {
                  this.messge_result='';
                  this.msgg = '';
          
                },2000);
              }, 2000);





        //       setTimeout(() => {
         
        //         if (this.res.status == '200') {
        //          // window.location.reload();
        //         window.open(uId.link);
        //           this.st_msg = this.res.body.message;
        //           this.staus_sucess=true;
        //           this.messageEvent.emit(this.st_msg);
        //         } else if (this.res.status == '203') {
        //           //console.log(this.res.status);
        //           this.false_sucess=true;
        // this.st_msg = this.res.body.message;
        // this.messageEvent.emit(this.st_msg);
        //         } else {
        //           this.false_sucess=true;
        //           this.st_msg = this.res.body.message;
        //           this.messageEvent.emit(this.st_msg);
        //         }
      
      
      
        //         setTimeout(() => {
        //           this.st_msg = ''; 
        //           this.staus_sucess=false;
        //           this.false_sucess=false;
        //       }, 3000);
        //       }, 3000);










            });
        })
      )
      .subscribe({});
  }

  createAudioItem(item: AudioArchiveInterface): FormGroup {
    return this.formBuilder.group({
      file_id: [item.id],
      updated_on: [item.updated_on],
      created_on: [item.created_on],
      description: [item.description],
      slug: [item.slug],
      feedback: [item.feedback],
      ifFeedbackDone: [!item.feedback],
    });
  }

  allStatus: any;
  performanceMenu = PerformanceReport.menuMethod;
  courseLevel: null | undefined | CourseLevelInterface;
  courseName: any;
  selectedIndex!: string;

  ngOnInit(): void {}

  getModuleByLevel(id: string, index: number) {
    this.selectedIndex = id.toString();
    this.userData
      .callApi(
        { course_level_id: id, user_id: this.userId },
        VariableConstants.METHOD_GET,
        RequestMapper.API_TEACHER_COURSE_ENROLLMENT,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.courseName = result.data;
        console.log(this.courseName);
        this.loading = false;
      });
  }

  loading: boolean = true;
  status: any;
  report: any = [];
  show_table: boolean = false;
  show_active: boolean = false;
  selectedType: string = '';
  coacwa(data: any) {
    console.log(data.course_id);
    let course_id = data.course_id;
    let course_level_id = data.course_level_id;
    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_COA_CWA_GET_ALL +
          '?course_id=' +
          course_id +
          '&course_level_id=' +
          course_level_id,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.show_table = true;
        this.report = result;
        console.log(this.report.code);
        this.status = this.report.code;
        //  this.show_active = 'active';
        this.show_active = !this.show_active;
      });
  }

  download_url(slug: any) {
    var x = localStorage.getItem('token');
    console.log(slug);

    console.log(x);
    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_FILE_DOWNLOAD + '/' + slug + '?api-key=' + x,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        console.log(result);
      });

    //const content = 'This is the content of the file you want to download.';
    //const fileUrl = "https://svp.payrollease.in/api/file/download/"+slug; // Replace with the actual URL of the file you want to download

    // this.userData.downloadFile(fileUrl).subscribe(blob => {
    //   const link = document.createElement('a');
    //   link.href = window.URL.createObjectURL(blob);
    //   link.download = 'downloaded_file';
    //   link.click();
    // });
  }
  activeTab: number | null = null; // Set the initial active tab

  selectTab(tabNumber: number) {
    this.activeTab = tabNumber;
  }

  res: any;

  data_gets: any;
  submitFeedback(formIndex: number) {
    const { file_id, slug, feedback } = this.audioItemLists.value[formIndex];

    this.userData
      .callApi(
        { file_id, slug, feedback },
        VariableConstants.METHOD_POST,
        RequestMapper.API_ARCHIVE_FEEDBACK,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.res = result;
        this.audioItemLists.controls[formIndex]
          .get('ifFeedbackDone')
          .setValue(true);
        this.submitFeedbackBeh$.next(true);
        this.cdr.markForCheck();
        console.log(this.res);
      });
  }

  get audioItemLists(): any {
    return this.audioItemForm.get('listItems') as any;
  }

  addAudioItem(item: AudioArchiveInterface) {
    this.audioItemLists.push(this.createAudioItem(item));
  }
}
