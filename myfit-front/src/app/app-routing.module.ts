import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LoginPageComponent } from "./module/LoginPageComponent/loginPage-component";
import { HomePageComponent } from "./module/HomePageComponent/homePage-component";
import { RegisterPageComponent } from "./module/RegisterPageComponent/registerPage-component";
import {MonCompteComponent} from "./module/monComptePageComponent/monCompte.component";
import {InfoUserComponent} from "./component/InfoUser/infoUser.component";
import {ErrorPageComponent} from "./module/ErrorPageComponent/errorPage-component";
import {AuthGardService} from "./services/authGard/authGard.service";

const routes: Routes = [
  {
    path: '',
    redirectTo: 'home',
    pathMatch: 'full'
  },
  {
    path : 'home',
    component : HomePageComponent,
    title: 'Accueil'
  },
  {
    path : 'login',
    component : LoginPageComponent,
    title: 'Connexion'

  },
  {
    path : 'register',
    component : RegisterPageComponent,
    title: 'Inscription'
  },
  {
    path: 'compte',
    component: MonCompteComponent,
    canActivate: [AuthGardService]
  },
  {
    path: 'infoUser',
    component: InfoUserComponent,
    canActivate: [AuthGardService]
  },
  {
    path: '**',
    component: ErrorPageComponent
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
