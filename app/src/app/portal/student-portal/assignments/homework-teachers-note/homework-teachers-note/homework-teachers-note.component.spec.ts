import { ComponentFixture, TestBed } from '@angular/core/testing';

import { HomeworkTeachersNoteComponent } from './homework-teachers-note.component';

describe('HomeworkTeachersNoteComponent', () => {
  let component: HomeworkTeachersNoteComponent;
  let fixture: ComponentFixture<HomeworkTeachersNoteComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ HomeworkTeachersNoteComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(HomeworkTeachersNoteComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
