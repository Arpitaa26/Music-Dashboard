import { TestBed } from '@angular/core/testing';

import { NavDataTransferService } from './nav-data-transfer.service';

describe('NavDataTransferService', () => {
  let service: NavDataTransferService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(NavDataTransferService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
