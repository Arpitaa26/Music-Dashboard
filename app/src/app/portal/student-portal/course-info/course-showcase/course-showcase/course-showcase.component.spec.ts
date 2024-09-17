import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CourseShowcaseComponent } from './course-showcase.component';

describe('CourseShowcaseComponent', () => {
  let component: CourseShowcaseComponent;
  let fixture: ComponentFixture<CourseShowcaseComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ CourseShowcaseComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(CourseShowcaseComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
