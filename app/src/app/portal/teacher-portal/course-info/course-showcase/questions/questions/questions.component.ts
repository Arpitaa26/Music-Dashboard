import { Component, Input } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { take } from 'rxjs';
import { RequestMapper } from 'src/app/request-mapper';
import { UserDataService } from 'src/app/services/user-data.service';
import { VariableConstants } from 'src/app/variable-contants';
import {
  ModuleTeachService,
  SelectedData,
  SelectedItem,
} from '../../../services/module-teach.service';

@Component({
  selector: 'app-questions',
  templateUrl: './questions.component.html',
  styleUrls: ['./questions.component.scss'],
})
export class QuestionsComponent {
  radioSelected: string | undefined;
  radioSelectedString: string | undefined;
  user_Id: any;
  constructor(
    private userData: UserDataService,
    private aroute: ActivatedRoute,
    private moduleTeach: ModuleTeachService
  ) {
    this.user_Id = localStorage.getItem('user_id')?.toString();

    this.moduleTeach.selectedItemTeacher.subscribe((data: SelectedData) => {
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
  isLoading: boolean = true;
  // Quiz_get_all api call
  getQuestionByTutorial(id: number): void {
    this.userData
      .callApi(
        {},
        VariableConstants.METHOD_GET,
        RequestMapper.API_QUIZ_GET_ALL + '?tutorial_id=' + id,
        VariableConstants.ACCESS_PRIVATE
      )
      .subscribe((result: any) => {
        // this. = result;

        this.question = result.data || [];
        this.isLoading = false;
        console.log(this.question);
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
        this.question = result.data || [];
        this.isLoading = false;
      });
  }

  //  quiz_get_all() {

  //   }

  allQues: any = [];
  question_res: any = [];
  question_ans(data: any) {
    let anId = data.ans_id;
    let ans = data.answer;
    let question_id = data.question_id;
    let question_index = data.question_index;
    this.allQues = {
      user_id: this.user_Id,
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
