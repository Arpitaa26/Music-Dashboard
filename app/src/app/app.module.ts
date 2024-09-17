import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { SidebarModule } from './sidebar/sidebar.module';
import { NavModule } from './nav/nav.module';
import { HttpClientModule } from '@angular/common/http';
import { RouterModule } from '@angular/router';
import { SignupComponent } from './signup/signup/signup.component';
// import { ForgotPasswordComponent } from './forgot-password/forgot-password/forgot-password.component';
import { UpdateProfileComponent } from './update-profile/update-profile.component';
import { ToastrModule } from 'ngx-toastr';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { CourseAllModule } from './course-all/course-all.module';
import { BmxToastModule } from 'bmx-toast';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { UpdatePasswordComponent } from './update-password/update-password/update-password.component';
import { CustomdatePipe } from './date/customdate.pipe';
import { ReplaceAndTrimPipe } from './trim/replace-and-trim.pipe';
import { ClipboardModule } from 'ngx-clipboard';
import { LimitCharactersPipe } from './limitCharacters/limit-characters.pipe';

// import { DateSortPipe } from './pipes/date-sort.pipe';

// import { adapterFactory } from 'angular-calendar/date-adapters/date-fns';
// import { FlatpickrModule } from 'angularx-flatpickr';

@NgModule({
  declarations: [
    AppComponent,
    UpdateProfileComponent,
    UpdatePasswordComponent,
    ReplaceAndTrimPipe,

    
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    SidebarModule,
    CourseAllModule,
    NavModule,
    ToastrModule.forRoot(),
    BrowserAnimationsModule,
    HttpClientModule,
    RouterModule.forRoot([{ path: 'signup', component: SignupComponent }]),
    // FullCalendarModule,
    BmxToastModule,
    ReactiveFormsModule,
    FormsModule,
    ClipboardModule,
  ],
  providers: [],
  bootstrap: [AppComponent],
})
export class AppModule {}
