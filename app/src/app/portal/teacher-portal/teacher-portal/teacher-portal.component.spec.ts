import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TeacherportalComponent } from './teacherportal.component';

describe('TeacherportalComponent', () => {
  let component: TeacherportalComponent;
  let fixture: ComponentFixture<TeacherportalComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TeacherportalComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(TeacherportalComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
