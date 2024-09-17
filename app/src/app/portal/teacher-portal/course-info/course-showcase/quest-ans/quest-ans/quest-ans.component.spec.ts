import { ComponentFixture, TestBed } from '@angular/core/testing';

import { QuestAnsComponent } from './quest-ans.component';

describe('QuestAnsComponent', () => {
  let component: QuestAnsComponent;
  let fixture: ComponentFixture<QuestAnsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ QuestAnsComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(QuestAnsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
