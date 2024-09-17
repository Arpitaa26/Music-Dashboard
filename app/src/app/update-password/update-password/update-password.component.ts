import { Component, OnInit } from '@angular/core';
import { FormGroup,FormControl,Validator, Validators, AbstractControl, ReactiveFormsModule  } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';

@Component({
  selector: 'app-update-password',
  templateUrl: './update-password.component.html',
  styleUrls: ['./update-password.component.scss']
})
export class UpdatePasswordComponent implements OnInit {
  datapass= new FormGroup({
   
    password : new FormControl("",[Validators.required]),
    conpassword: new FormControl("",[Validators.required])
  })
  forgotPass = new FormGroup({
    email: new FormControl('', [Validators.email, Validators.required]),
  });
  addform =new FormGroup({
    name:new FormControl('',[Validators.required]),
    address:new FormControl('',[Validators.required]),
    email_id:new FormControl('',[Validators.required,Validators.email]),
    phone:new FormControl('',[Validators.required]),
    gender:new FormControl('',[Validators.required]),
    password:new FormControl('',[Validators.required,Validators.minLength(5)])
  })
  encryptionService: any;
  constructor(private userData: UserDataService, private router: Router,private userroute:ActivatedRoute) {}
  wrap:any;

  ngOnInit(): void {
    let url = window.location.href;

    console.log(url)
    // let paramString = url.split('?')[1];
    // let queryString = new URLSearchParams(paramString);
    // for(let urlitem of queryString.entries()){
    //   console.log(urlitem);
    
   
    // }
    
    
  }
  update_msg:any;
//UPDATE PASSWORD
  onSubmit(data:any) {
    // let inpData = this.forgotPass.value;
    // console.log(inpData);

    // this.userData
    //   .callApi(
    //     inpData,
    //     VariableConstants.METHOD_POST,
    //     RequestMapper.API_FORGOT_PASSWORD,
    //     VariableConstants.ACCESS_PUBLIC
    //   )
    //   .subscribe({
    //     next: (res) => {
    //       console.log(res);
    //     },
    //     error: (err) => {
    //       console.log(err);
    //     },
    //   });



    let id:any = this.userroute.snapshot.params['id'];
    let token:any = this.userroute.snapshot.params['token'];
    // console.log(id);
    // console.log(token);
   
    // let secretkey= {user_id:id,token:token}
    //  let encryptedData = this.encryptionService.encryptData(secretkey);
    let alldata={password: data.value.password, cpassword: data.value.conpassword,user_id:id,token:token};
    console.log(alldata)


    this.userData.callApi(alldata,
      VariableConstants.METHOD_POST,
      RequestMapper.API_UPDATE_PASSWORD,
      VariableConstants.ACCESS_PUBLIC
    )
    .subscribe((result: any) => {
   this.update_msg = result;
     console.log(this.update_msg.body.message);
     this.wrap = this.update_msg.body.message;
     setTimeout(()=>{                           // <<<---using ()=> syntax
      
      this.router.navigate(['/' + RequestMapper.LOGIN])
  }, 6000);
    });
  }
  // getControl(name: any): AbstractControl | null {
  //   return this.updateForm.get(name);
  // }
  getControl(name: any): AbstractControl | null {
    return this.forgotPass.get(name);
  }

  redirect() {
    this.router.navigate(['/signup']);
  }
  login_redirect() {
    this.router.navigate(['']);
  }
  getUpdateuser(data:any){
    // let inpData = this.upform.value;
    console.log(data,);
  }
  userdata:any=[];
  
  onSubmitupdate(data:any){
    // this.userdata = data.value;
   
  }
}


