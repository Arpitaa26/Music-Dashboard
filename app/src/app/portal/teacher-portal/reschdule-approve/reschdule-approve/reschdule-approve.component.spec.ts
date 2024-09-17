import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ReschduleApproveComponent } from './reschdule-approve.component';

describe('ReschduleApproveComponent', () => {
  let component: ReschduleApproveComponent;
  let fixture: ComponentFixture<ReschduleApproveComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [ReschduleApproveComponent]
    });
    fixture = TestBed.createComponent(ReschduleApproveComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
