import { Component } from '@angular/core';
import { FormGroup,FormControl, Validators } from '@angular/forms';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
@Component({
  selector: 'app-additional-details',
  templateUrl: './additional-details.component.html',
  styleUrls: ['./additional-details.component.scss']
})
export class AdditionalDetailsComponent {
  additiona_ldetails=new FormGroup({
    date_of_joining: new FormControl('',[Validators.required]),
    concerts: new FormControl('',[Validators.required]),
    achivements: new FormControl('',[Validators.required]),
    date_of_contract_teacher: new FormControl('',[Validators.required]),
    date_of_training_period: new FormControl('',[Validators.required]),
    date_of_contract_Academy: new FormControl('',[Validators.required]),
    file_name: new FormControl(''),
    category:new FormControl(''),

  });

  // userData: any;
  selectedFile:File|null=null;
  onFileSelected(event: any) {
    this.selectedFile = event.target.files[0] as File;
    console.log(this.selectedFile.name)
  }








user_ids=localStorage.getItem("user_id");

constructor(private userData:UserDataService){}

  add_details(data:any){
    console.log(data.value)

    let category = "RESUME";
    if (this.selectedFile) {
      let formData:any= new FormData();

      // formData.append("category", "RESUME");
      formData.append("file_name", this.selectedFile, this.selectedFile.name);
      formData.append("concerts", data.value.concerts);
      formData.append("achivements", data.value.achivements);
      formData.append("date_of_joining", data.value.date_of_joining);
      formData.append("date_of_training_period", data.value.date_of_training_period);
      formData.append("date_of_contract_teacher", data.value.date_of_contract_teacher);
      formData.append("date_of_contract_Academy", data.value.date_of_contract_Academy);
     this.userData.callApi(
      formData,
      VariableConstants.METHOD_FILE_POST,
      RequestMapper.API_TEACHER_ADDITIONAL_DETAILS + this.user_ids,
      VariableConstants.ACCESS_PRIVATE
    )
    .subscribe((result: any) => {
         console.log(result)


    })
  }

  }
}
