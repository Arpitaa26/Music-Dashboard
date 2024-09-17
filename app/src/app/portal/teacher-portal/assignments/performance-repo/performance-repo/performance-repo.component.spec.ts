import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PerformanceRepoComponent } from './performance-repo.component';

describe('PerformanceRepoComponent', () => {
  let component: PerformanceRepoComponent;
  let fixture: ComponentFixture<PerformanceRepoComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PerformanceRepoComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(PerformanceRepoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
