import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TwoCourseComponentComponent } from './two-course-component.component';

describe('TwoCourseComponentComponent', () => {
  let component: TwoCourseComponentComponent;
  let fixture: ComponentFixture<TwoCourseComponentComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [TwoCourseComponentComponent]
    });
    fixture = TestBed.createComponent(TwoCourseComponentComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
