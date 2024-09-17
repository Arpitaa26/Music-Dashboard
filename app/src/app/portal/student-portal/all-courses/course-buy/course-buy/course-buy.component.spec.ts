import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CourseBuyComponent } from './course-buy.component';

describe('CourseBuyComponent', () => {
  let component: CourseBuyComponent;
  let fixture: ComponentFixture<CourseBuyComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [CourseBuyComponent]
    });
    fixture = TestBed.createComponent(CourseBuyComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
