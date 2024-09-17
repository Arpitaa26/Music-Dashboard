import { Component, ElementRef, Input, OnInit, ViewChild } from '@angular/core';
import {
  FormGroup,
  FormControl,
  Validators,
  FormBuilder,
} from '@angular/forms';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import { ActivatedRoute, Params } from '@angular/router';
import { SupportService } from '../../services/support.service';

@Component({
  selector: 'app-comment-section',
  templateUrl: './comment-section.component.html',
  styleUrls: ['./comment-section.component.scss'],
})
export class CommentSectionComponent implements OnInit {
  @ViewChild('inputFile') myInputVariable!: ElementRef;
  base_url = 'https://thesvpacademy.com/admin/file/open/';
  commentData: any;
  task_id: any;
  user_id: any;
  @Input() status: any;
  fileToUpload: File | null = null;
  uploadedFiles!: File;
  constructor(
    private userData: UserDataService,
    private activeRout: ActivatedRoute,
    private fb: FormBuilder,
    private supportApiService: SupportService
  ) {}
  form!: FormGroup;
  public full_name: string = '';
  public created_on: string = '';
  file: File | null = null;

  ngOnInit(): void {
    //name

    this.form = this.fb.group({
      task_comment: [''],
      file: ['', [Validators.required]],
      full_name: [localStorage.getItem('user_full_name')!],
      created_on: [''],
      user_id: [localStorage.getItem('user_id')?.toString()],
      task_id: [this.activeRout.snapshot.paramMap.get('ticketId')?.toString()],
      attachment: [null],
    });

    this.getAll();

    this.user_id = localStorage.getItem('user_id')?.toString();
  }

  getAll() {
    const { params } = this.activeRout.snapshot;
    this.supportApiService
      .getAllMessages(params['ticketId']?.toString())
      .subscribe((result: any) => {
        console.log(result.data);
        this.commentData = result.data.reverse();

        if (this.commentData == null) {
          this.commentData = [];
        }

        // debugger;
        // console.log(this.commentData);
        // // this.task_id = result.data[0].task_id;
      });
  }

  submitForm() {
    this.form.controls['created_on'].setValue(new Date());

    //time

    if (this.file) {
      // this.form.controls['attachment'].setValue(this.file);
      const myFormValue = this.form.value;

      const formData = new FormData();

      formData.append('task_comment', this.form.get('task_comment')?.value);
      formData.append('full_name', this.form.get('full_name')?.value);
      formData.append('user_id', this.form.get('user_id')?.value);
      formData.append('task_id', this.form.get('task_id')?.value);
      formData.append('created_on', this.form.get('created_on')?.value);
      formData.append('attachment', this.file, this.file.name);
      // formData.append('description', description);

      this.supportApiService
        .postCommentWithAttachment(formData)
        .subscribe((res) => {
          setTimeout(() => {
            this.form.get('task_comment')?.setValue('');
            this.myInputVariable.nativeElement.value = null;
          }, 2000);
          this.getAll();
          window.location.reload();
        });
    } else {
      let inpData = this.form.value;
      this.commentData.push(inpData);
      this.supportApiService.postComment(inpData).subscribe((res) => {
        setTimeout(() => {
          this.form.get('task_comment')?.setValue('');
          this.myInputVariable.nativeElement.value = null;
        }, 2000);
      });
    }
  }

  onFileSelect(event: any): void {
    const file: File = event?.target?.files[0];
    if (file) {
      this.file = file;
    } else {
      console.log('No file selected');
    }
  }
}

import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'orderByDate2',
  pure: false,
})
export class DateSort2Pipe implements PipeTransform {
  transform(array: any[], property: string, order: 'asc' | 'desc'): any[] {
    if (!Array.isArray(array) || !property) {
      return array;
    }

    array.sort((a, b) => {
      const dateA = new Date(a[property]);
      const dateB = new Date(b[property]);

      if (order === 'asc') {
        return dateA.getTime() - dateB.getTime();
      } else {
        return dateB.getTime() - dateA.getTime();
      }
    });

    return array;
  }
}
