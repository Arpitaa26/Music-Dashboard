import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { CourseInfoRoutingModule } from './course-info-routing.module';
import { CourseInfoComponent } from './course-info/course-info.component';
import { LimitCharactersPipe } from 'src/app/limitCharacters/limit-characters.pipe';

@NgModule({
  declarations: [CourseInfoComponent],
  imports: [CommonModule, CourseInfoRoutingModule ],
})
export class CourseInfoModule {}
