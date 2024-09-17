import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { CourseShowcaseRoutingModule } from './course-showcase-routing.module';
import { CourseShowcaseComponent } from './course-showcase/course-showcase.component';
import { CarouselModule } from 'ngx-owl-carousel-o';
import { OverviewModule } from './overview/overview.module';
import { QuestAnsModule } from './quest-ans/quest-ans.module';
import { QuestionsModule } from './questions/questions.module';
import { NgImageSliderModule } from 'ng-image-slider';
import { ImagePopupComponent } from './image-popup/image-popup.component';

@NgModule({
  declarations: [CourseShowcaseComponent, ImagePopupComponent],
 
  imports: [
    CommonModule,
    CourseShowcaseRoutingModule,
    CarouselModule,
    OverviewModule,
    QuestAnsModule,
    QuestionsModule,NgImageSliderModule
  ]
  
})
export class CourseShowcaseModule {}
