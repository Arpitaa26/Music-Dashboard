import { Component } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
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
  constructor(
    private userData: UserDataService,
    private route: ActivatedRoute
  ) {}
  question: any = [];

  // Quiz_get_all api call
  course_id: any;
  module_id: any;
  null_data: any;
  ngOnInit(): void {
    this.course_id = this.route.snapshot.params['levelId'];
    this.module_id = this.route.snapshot.params['moduleId'];
    console.log('test:' + this.course_id);
    console.log('test:' + this.module_id);

    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_QUIZ_GET_ALL +
          '?course_id=' +
          this.course_id +
          '&module_id=' +
          this.module_id,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: { data: any; message: string }) => {
        this.question = result;
      });
  }

  //  quiz_get_all() {

  //   }
  user_Id: any = localStorage.getItem('user_id');

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
