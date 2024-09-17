import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CoaCwaReportComponent } from './coa-cwa-report.component';

describe('CoaCwaReportComponent', () => {
  let component: CoaCwaReportComponent;
  let fixture: ComponentFixture<CoaCwaReportComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [CoaCwaReportComponent]
    });
    fixture = TestBed.createComponent(CoaCwaReportComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
