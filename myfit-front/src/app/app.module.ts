import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { HomePageComponent } from "./module/HomePageComponent/homePage-component";
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MenuComponent } from "./component/Menu/menu-component";
import { MatCardModule } from "@angular/material/card";
import { LoginPageComponent } from "./module/LoginPageComponent/loginPage-component";

import { MatButtonModule } from '@angular/material/button';
import { MatInputModule } from '@angular/material/input';
import { FormsModule } from "@angular/forms";
import { MatFormFieldModule } from "@angular/material/form-field";
import { FlexLayoutModule } from "@angular/flex-layout";
import { RegisterPageComponent } from "./module/RegisterPageComponent/registerPage-component";
import {MatSnackBar} from "@angular/material/snack-bar";

@NgModule({
  declarations: [
    AppComponent,
    HomePageComponent,
    MenuComponent,
    LoginPageComponent,
    RegisterPageComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    MatCardModule,
    MatFormFieldModule,
    MatInputModule,
    FormsModule,
    FlexLayoutModule,
    MatButtonModule
  ],
  exports: [
    MatButtonModule,
    MatInputModule,
  ],
  providers: [
    MatSnackBar
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
