import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { HomePageComponent } from "./module/HomePageComponent/homePage-component";
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import {MenuComponent} from "./component/Menu/menu-component";
import {MatCardModule} from "@angular/material/card";
import {FlexLayoutModule} from "@angular/flex-layout";
import {MatIconModule} from "@angular/material/icon";
import {MatFormFieldModule} from "@angular/material/form-field";
import {MatTooltipModule} from "@angular/material/tooltip";
import {MatButtonModule} from "@angular/material/button";
import {HttpClientModule} from "@angular/common/http";
import {ApiService} from "./services/api/api.service";
import {MealCardComponent} from "./component/Utils/mealCard/mealCard-component";
import {MatExpansionModule} from "@angular/material/expansion"
import {NgChartsModule} from "ng2-charts";
import {ObjectifViewComponent} from "./component/Utils/objectifView/objectifView.component";
import {GraphiqueEvolutionComponent} from "./component/Utils/graphiqueEvolution/graphiqueEvolution.component";
import { LoginPageComponent } from "./module/LoginPageComponent/loginPage-component";
import { RegisterPageComponent } from "./module/RegisterPageComponent/registerPage-component";
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import { MatInputModule } from '@angular/material/input';
import { MatSnackBar } from "@angular/material/snack-bar";
import {LoginDAO} from "./model/loginDAO";
import {ProfileUtilisateurComponent} from "./component/profileUtilisateur/profileUtilisateur.component";
import {MonCompteComponent} from "./module/monComptePageComponent/monCompte.component";
import {SideMenuComponent} from "./component/sideMenu/sideMenu.component";

@NgModule({
  declarations: [
    AppComponent,
    HomePageComponent,
    MenuComponent,
    MealCardComponent,
    ObjectifViewComponent,
    GraphiqueEvolutionComponent,
    LoginPageComponent,
    RegisterPageComponent,
    ProfileUtilisateurComponent,
    MonCompteComponent,
    SideMenuComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    MatCardModule,
    FlexLayoutModule,
    MatInputModule,
    MatIconModule,
    FormsModule,
    MatFormFieldModule,
    MatTooltipModule,
    MatButtonModule,
    HttpClientModule,
    ReactiveFormsModule,
    MatExpansionModule,
    NgChartsModule,
  ],
  providers: [
    ApiService,
    MatSnackBar,
    FlexLayoutModule,
    MatIconModule,
    MatFormFieldModule,
    MatTooltipModule,
    MatButtonModule,
    ApiService,
    LoginDAO,
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
