import { Component } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { ModuleTeachService, SelectedData, SelectedItem } from 'src/app/portal/teacher-portal/course-info/services/module-teach.service';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';

@Component({
  selector: 'app-questions',
  templateUrl: './questions.component.html',
  styleUrls: ['./questions.component.scss'],
})
export class QuestionsComponent {
  radioSelected: string | undefined;
  radioSelectedString: string | undefined;
 
  user_Id: any;
  isLoading:boolean =true
  constructor(
    private userData: UserDataService,
    private aroute: ActivatedRoute,
    private moduleTeach: ModuleTeachService,

    private route: ActivatedRoute
  ) {
    this.user_Id = localStorage.getItem('user_id')?.toString();

    this.moduleTeach.selectedItemStudent.subscribe((data: SelectedData) => {
      this.question = [];
      this.isLoading = true;
      if (data.mode === SelectedItem.Module) {
        this.getQuestionByModule();
      }
      if (data.mode === SelectedItem.Tutorial) {
        this.getQuestionByTutorial(data.id);
      }
    });
  }

  
  question: any = [];

  // Quiz_get_all api call
  course_id: any;
  module_id: any;
  null_data: any;
  ngOnInit(): void {
    // this.course_id = this.route.snapshot.params['levelId'];
    // this.module_id = this.route.snapshot.params['moduleId'];
    // console.log('test:' + this.course_id);
    // console.log('test:' + this.module_id);

    // this.userData
    //   .callApi(
    //     {},
    //     VariableConstants.METHOD_GET,
    //     RequestMapper.API_QUIZ_GET_ALL +
    //       '?course_id=' +
    //       this.course_id +
    //       '&module_id=' +
    //       this.module_id,
    //     VariableConstants.ACCESS_PRIVATE
    //   )
    //   .subscribe((result: { data: any; message: string }) => {
    //     this.question = result;
    //   });
  }


   getQuestionByTutorial(id: number): void {
 
    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_QUIZ_GET_ALL + '?tutorial_id=' + id,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.isLoading = false;
        this.question = result.data ||[];
      });
  }

  getQuestionByModule(): void {
    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_QUIZ_GET_ALL +
          '?module_id=' +
          this.aroute.snapshot.paramMap.get('moduleId') +
          '&course_id=' +
          this.aroute.snapshot.paramMap.get('id'),
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        this.question = result.data ||[];
        this.isLoading = false
      });
  }
  //  quiz_get_all() {

  //   }
  // let user_Id: any = localStorage.getItem('user_id');

  allQues: any = [];
  question_res: any = [];
  question_ans(data: any) {
    this.course_id = this.route.snapshot.params['levelId'];
    console.log('test:' + this.course_id);
    let anId = data.ans_id;
    let ans = data.answer;
    let question_id = data.question_id;
    let question_index = data.question_index;
    this.allQues = {
      user_id: data.user_id,
      question_id: { [question_index]: question_id },
      answer: { [anId]: ans },
    };
    // console.log(this.allQues)
    // console.log(data.ans_id);
    this.userData
      .callApi(
        this.allQues,
        VariableConstants.METHOD_POST,
        RequestMapper.API_QUIZ_SAVE + this.user_Id,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        // this. = result;

        console.log(result);
        this.question_res = result;
        console.log(this.question_res.body.message);
      });
  }
}
