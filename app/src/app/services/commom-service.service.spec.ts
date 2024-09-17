import { TestBed } from '@angular/core/testing';

import { CommomServiceService } from './commom-service.service';

describe('CommomServiceService', () => {
  let service: CommomServiceService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(CommomServiceService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
