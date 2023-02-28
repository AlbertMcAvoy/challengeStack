import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LoginPageComponent } from "./module/LoginPageComponent/loginPage-component";
import { HomePageComponent } from "./module/HomePageComponent/homePage-component";
import { RegisterPageComponent } from "./module/RegisterPageComponent/registerPage-component";
import {MonCompteComponent} from "./module/monComptePageComponent/monCompte.component";

const routes: Routes = [
  {
    path : '',
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
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
