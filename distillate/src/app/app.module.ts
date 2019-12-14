import { BrowserModule } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { NgModule, NO_ERRORS_SCHEMA } from '@angular/core';
import { RouterModule } from '@angular/router';

import { HttpModule } from '@angular/http';
import { HttpClientModule } from '@angular/common/http';

import { AppComponent } from './app.component';
import { AppRoutingModule } from './app.routing';
import { FormsModule } from '@angular/forms';

import { MDBBootstrapModule } from 'angular-bootstrap-md';
import { NgxSpinnerModule } from 'ngx-spinner';
import { NavbarComponent } from './components/navbar.component';
import { DistillateComponent } from './pages/distillate/distillate.component';
import { APIRequest } from './services/api.service';
import { LoginComponent } from './pages/login/login.component';
@NgModule({
  declarations: [
    AppComponent,
    NavbarComponent,
    DistillateComponent,
    LoginComponent
  ],
  imports: [
    BrowserModule,
    BrowserAnimationsModule,
    FormsModule,
    RouterModule,
    HttpModule,
    HttpClientModule,
    MDBBootstrapModule.forRoot(),
    NgxSpinnerModule,
    AppRoutingModule,
  ],
  schemas: [NO_ERRORS_SCHEMA],
  providers: [
    APIRequest,
    HttpModule],
  bootstrap: [AppComponent]
})
export class AppModule { }
