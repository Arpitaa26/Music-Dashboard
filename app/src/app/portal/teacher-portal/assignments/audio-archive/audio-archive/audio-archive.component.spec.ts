import { ComponentFixture, TestBed } from '@angular/core/testing';
import { AudioArchiveComponent } from './audio-archive.component';


describe('AudioArchiveComponent', () => {
  let component: AudioArchiveComponent;
  let fixture: ComponentFixture<AudioArchiveComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AudioArchiveComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(AudioArchiveComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
