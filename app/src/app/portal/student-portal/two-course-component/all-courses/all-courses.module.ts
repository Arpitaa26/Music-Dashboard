import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { AllCoursesRoutingModule } from './all-courses-routing.module';
import { AllCoursesComponent } from './all-courses/all-courses.component';
import { FormsModule } from '@angular/forms';
import { CamelCaseToTitleCasePipe } from 'src/app/camelCaseToTitleCase/camel-case-to-title-case.pipe';
import { LimitCharactersPipe } from 'src/app/limitCharacters/limit-characters.pipe';
import { CardComponent } from './card/card.component';
import { ButtonComponent } from './button/button.component';


@NgModule({
  declarations: [
    AllCoursesComponent,LimitCharactersPipe,CamelCaseToTitleCasePipe, CardComponent, ButtonComponent
  ],
  imports: [
    CommonModule,
    AllCoursesRoutingModule,FormsModule,
  ]
})
export class AllCoursesModule { }  //B

// LimitCharactersPipe,CamelCaseToTitleCasePipe
