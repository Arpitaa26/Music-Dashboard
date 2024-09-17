import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { SignupRoutingModule } from './signup-routing.module';
import { SignupComponent } from './signup/signup.component';
import { HttpClientModule } from '@angular/common/http';
import { ReactiveFormsModule } from '@angular/forms';
import { ComponentModule } from '../component/component.module';
// import { NgxIntlTelInputModule } from 'ngx-intl-tel-input';

@NgModule({
  declarations: [SignupComponent],
  imports: [
    CommonModule,
    SignupRoutingModule,
    HttpClientModule,
    ReactiveFormsModule,
    ComponentModule,
  ],
})
export class SignupModule {}
