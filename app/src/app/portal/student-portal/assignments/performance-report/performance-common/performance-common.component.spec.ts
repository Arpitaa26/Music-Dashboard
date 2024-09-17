import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PerformanceCommonComponent } from './performance-common.component';

describe('PerformanceCommonComponent', () => {
  let component: PerformanceCommonComponent;
  let fixture: ComponentFixture<PerformanceCommonComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PerformanceCommonComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(PerformanceCommonComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
