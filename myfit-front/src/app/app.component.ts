import {Component, ComponentRef} from '@angular/core';
import {Router} from "@angular/router";
import {LoginPageComponent} from "./module/LoginPageComponent/loginPage-component";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {

  openSideMenu: boolean = false;

  title: string = 'Track\'n\'fit';

  menuAccountLink: string;

  openMenu() {
    this.openSideMenu = !this.openSideMenu;
  }

  constructor(private router: Router) {


    if (sessionStorage.getItem('token') != null) {
      this.menuAccountLink = 'compte';
    } else {
      this.menuAccountLink = 'login';
    }
  }

  getRoute(): string {
    return this.router.url
  }

  updateMenuLink() {
    if (sessionStorage.getItem('token') != null) {
      this.menuAccountLink = 'compte';
    }
  }

  passUpdateMenuLinkToLoginComponent(componentRef: ComponentRef<LoginPageComponent>) {

    if (!(componentRef instanceof LoginPageComponent)) {
      return;
    }

    componentRef.updateMenuLinkViaParent = this.updateMenuLink;
  }

  openSideMenuEvent() {
    this.openSideMenu = !this.openSideMenu;
  }
}

