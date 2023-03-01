import { Component } from '@angular/core';
import {Router} from "@angular/router";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {

  openSideMenu: boolean = true;
  title = 'myfit-front';

  openMenu() {
    this.openSideMenu = !this.openSideMenu;
  }

  constructor(private router: Router) {
  }

  getRoute(): string {
    return this.router.url
  }
}

