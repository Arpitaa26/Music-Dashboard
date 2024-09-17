import { Component, OnInit } from '@angular/core';
import { de } from 'date-fns/locale';
import { abhyasAudioArchiveInterface } from 'src/app/basic-module/reschedule/interface/abhyas_audio_interface';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import { FormControl, FormGroup, Validators } from '@angular/forms';
export interface audio {
  category: string;
  file: string;
  description: string;
}
@Component({
  selector: 'app-abhyas-audio-archive',
  templateUrl: './abhyas-audio-archive.component.html',
  styleUrls: ['./abhyas-audio-archive.component.scss'],
})
export class AbhyasAudioArchiveComponent implements OnInit {
  filesUpload: any;
  audio_upload = new FormGroup({
    // file: new FormControl('', [Validators.required]),
    description: new FormControl('', [Validators.required]),
    category: new FormControl(''),
  });
  // get file() {
  //   return this.audio_upload.get('file');
  // }
  // get description() {
  //   return this.audio_upload.get('description');
  // }
  constructor(private userdataservice: UserDataService) {}
obj:any=[]
  abhyasAudioArchiveInterface: null | undefined | abhyasAudioArchiveInterface;
  ngOnInit() {
    localStorage.setItem('category_name', 'AUDIO_ARCHIVE');
    let cat = localStorage.getItem('category_name');
    console.log(cat);
    this.userdataservice
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_AUDIO_ARCHIVE_GET_ALL,
        VariableConstants.ACCESS_PRIVATE
      )
      
      .subscribe((result: any) => {
        console.log(result);
    
        this.abhyasAudioArchiveInterface = result;
        this.obj = this.abhyasAudioArchiveInterface?.data
        this.allStatus= result.code 
        if (result.code == '200') {
        } else if (result.code == '203') {
          this.messge_result = 'No Audio uploaded yet';
        }
        console.log(typeof(this.abhyasAudioArchiveInterface?.data.slice().reverse()));
       
      });
   
  }

  allStatus:any;
  messge_result: any;
  get descendingItems(): any[] {
    return this.obj.slice().sort().reverse();
  }

  toDisplay: boolean = false;
  toggleData() {
    this.toDisplay = !this.toDisplay;
  }
  popupoff() {
    this.toDisplay = !this.toDisplay;
  }
  formData = new FormData();
  // handleFileInput(event: any) {
  //   if (event.target.files.length > 0) {
  //     this.filesUpload = event.target.files[0];
  //     this.formData.append('file', this.filesUpload);
  //     console.log(this.filesUpload.name);
  //     setTimeout(() => {
  //       this.audio_upload.controls['file'].setValue(event.target.files[0]);
  //       console.log(this.formData);
  //     }, 2000);

  
  //   }
  // }
  // console.log(this.audio_upload.controls['file'].value);
  selectedFile:File|null=null;
  onFileSelected(event: any) {
    this.selectedFile = event.target.files[0] as File;
    console.log(this.selectedFile.name)
  }
  getUserFormData(data: any) {
    //let 
    let description=data.description;
    let category = "AUDIO_ARCHIVE";
 
    if (this.selectedFile) {
      let formData:any= new FormData();
      
      formData.append("category", category);
      formData.append("file", this.selectedFile, this.selectedFile.name);
      formData.append("description", description);
   
      // formData.append("description",description);
      // formData.append("category",category)
   
    //  let all = {file,description: description, category: category};

    console.log(formData);

    // this.audio_upload.controls['category'].setValue('AUDIO_ARCHIVE');
    // let inpData = this.audio_upload.value;
    // // data[0].append(this.filesUpload);
    // const formData = new FormData();
    // formData.append('file', this.filesUpload);
    // formData.append('description', data.description);
    // formData.append('category', 'AUDIO_ARCHIVE');
    // console.log(formData);

   

    console.log(this.formData);

    this.userdataservice
      .callApi(
        formData,
        VariableConstants.METHOD_FILE_POST,
        RequestMapper.API_AUDIO_ARCHIVE_UPLOAD,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        console.log(result);
      });
    }
  }
}
