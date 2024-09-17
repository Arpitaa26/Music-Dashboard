import { Component, OnInit } from '@angular/core';
import { RequestMapper } from 'src/app/request-mapper';
import { VariableConstants } from 'src/app/variable-contants';
import { UserDataService } from 'src/app/services/user-data.service';
import { abhyasAudioArchiveInterface } from '../abhyas-audio-archive-interface';


@Component({
  selector: 'app-abhyas-audio-archieve',
  templateUrl: './abhyas-audio-archieve.component.html',
  styleUrls: ['./abhyas-audio-archieve.component.scss']
})
export class AbhyasAudioArchieveComponent implements OnInit {

  allStudentsInfo:any = [];
  studentId:any = [];

  userdataservice: any;
  constructor ( private userData:UserDataService ) { }
  abhyasAudioArchiveInterface:null|undefined|abhyasAudioArchiveInterface;
  ngOnInit(): void {


    this.getStudentsDetails();


    // localStorage.setItem('category_name', 'AUDIO_ARCHIVE');
    // let cat = localStorage.getItem('category_name');
    // console.log(cat);
    // this.userdataservice
    //   .callApi(
    //     {},
    //     VariableConstants.METHOD_GET,
    //     RequestMapper.API_AUDIO_ARCHIVE_GET_ALL,
    //     VariableConstants.ACCESS_PRIVATE
    //   )
    //   .subscribe((result: any) => {
    //    console.log(result);
    //
    //     this.abhyasAudioArchiveInterface = result;

    //     console.log(this.abhyasAudioArchiveInterface?.data);
    //   });






  }



  allStudentsInfo_uniq:any =[]
  getStudentsDetails(){
    var classObj = this;
    this.userData.callApi(

      {},
      VariableConstants.METHOD_GET,
      RequestMapper.API_COURSE_ENROLLMENT,
      VariableConstants.ACCESS_PRIVATE
    ).subscribe((res: any)=>{
      // console.log(res);
      this.allStudentsInfo = res;
      var uniquelist:any = [];
      this.allStudentsInfo!.data.forEach(function (data:any) {
        if (!uniquelist[data.user_fullname]) {
          uniquelist[data.user_fullname]=1;
          classObj.allStudentsInfo_uniq.push(data);
        }

      });
    });
  }

   // console.log(res);

  // allStudentsInfo_uniq:any =[]

  // getStudentDetails(){
  //   var classObj = this;
  //    this.userData.callApi(
  //       {},
  //       VariableConstants.METHOD_GET,
  //       RequestMapper.API_COURSE_ENROLLMENT,
  //       VariableConstants.ACCESS_PRIVATE
  //     ).subscribe((res)=>{
  //      this.allStudentsInfo = res;
  //       var uniquelist:any = [];
  //       this.allStudentsInfo!.data.forEach(function (data:any) {
  //         if (!uniquelist[data.user_fullname]) {
  //           uniquelist[data.user_fullname]=1;
  //           classObj.allStudentsInfo_uniq.push(data);
  //         }

  //       });
  //     });
  // }

  // onSelectStudent(){
  //   console.log(this.studentId);

  // }

  getAudio(){
    this.userData.callApi(
      {},
      VariableConstants.METHOD_GET,
      RequestMapper.API_AUDIO_ARCHIVE_GET_ALL,
      VariableConstants.ACCESS_PRIVATE
  ).subscribe((result: any) => {
    console.log(result);
    this.abhyasAudioArchiveInterface = result;

    console.log(this.abhyasAudioArchiveInterface?.data)

  });

  }
  messge_result:any;
  toDisplay:boolean = false;
    toggleData(){
        this.toDisplay = !this.toDisplay;
    }
    popupoff(){
      this.toDisplay = !this.toDisplay;
    }



    all_event:any=[];
    toDisplayy: boolean = false;
    onSelectStudent(value:any){

      this.toDisplay = !this.toDisplay;
      this.all_event = value;
      console.log(this.all_event)

//audio add

this.userData.callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_AUDIO_ARCHIVE_GET_ALL+"&user_id="+this.all_event,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        console.log(result);

        this.abhyasAudioArchiveInterface = result;
        console.log(result.message);
        if(result.code=='200'){

        }else if(result.code=='203'){
this.messge_result = "No Audio uploaded yet";
        }
      });

    }

}
