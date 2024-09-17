import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AbhyasAudioArchieveComponent } from './abhyas-audio-archieve.component';

describe('AbhyasAudioArchieveComponent', () => {
  let component: AbhyasAudioArchieveComponent;
  let fixture: ComponentFixture<AbhyasAudioArchieveComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AbhyasAudioArchieveComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(AbhyasAudioArchieveComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
