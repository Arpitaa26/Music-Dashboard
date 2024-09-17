import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CourseAllComponent } from './course-all.component';

describe('CourseAllComponent', () => {
  let component: CourseAllComponent;
  let fixture: ComponentFixture<CourseAllComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ CourseAllComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(CourseAllComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
