import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CompletedClassComponent } from './completed-class.component';

describe('CompletedClassComponent', () => {
  let component: CompletedClassComponent;
  let fixture: ComponentFixture<CompletedClassComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ CompletedClassComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(CompletedClassComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
