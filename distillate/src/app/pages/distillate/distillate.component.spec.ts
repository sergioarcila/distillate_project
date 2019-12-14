import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DistillateComponent } from './distillate.component';

describe('DistillateComponent', () => {
  let component: DistillateComponent;
  let fixture: ComponentFixture<DistillateComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DistillateComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DistillateComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
