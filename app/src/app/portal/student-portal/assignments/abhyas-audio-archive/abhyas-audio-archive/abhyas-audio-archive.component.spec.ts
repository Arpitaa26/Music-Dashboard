import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AbhyasAudioArchiveComponent } from './abhyas-audio-archive.component';

describe('AbhyasAudioArchiveComponent', () => {
  let component: AbhyasAudioArchiveComponent;
  let fixture: ComponentFixture<AbhyasAudioArchiveComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AbhyasAudioArchiveComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(AbhyasAudioArchiveComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
