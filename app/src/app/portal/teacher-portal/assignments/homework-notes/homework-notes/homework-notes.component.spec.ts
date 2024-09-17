import { ComponentFixture, TestBed } from '@angular/core/testing';

import { HomeworkNotesComponent } from './homework-notes.component';

describe('HomeworkNotesComponent', () => {
  let component: HomeworkNotesComponent;
  let fixture: ComponentFixture<HomeworkNotesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ HomeworkNotesComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(HomeworkNotesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
