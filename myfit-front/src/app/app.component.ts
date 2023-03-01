import {Component, OnInit} from '@angular/core';
import {Router} from "@angular/router";
import {BreakpointObserver, Breakpoints} from "@angular/cdk/layout";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit{

  openSideMenu: boolean = true;
  title = 'myfit-front';

  openMenu() {
    this.openSideMenu = !this.openSideMenu;
  }

  constructor(private router: Router, private responsive: BreakpointObserver) {
  }

  getRoute(): string {
    return this.router.url
  }
  openSideMenuEvent() {
    this.openSideMenu = !this.openSideMenu;
  }
  ngOnInit() {
    this.responsive.observe(Breakpoints.Web)
      .subscribe(result => {

        if (result.matches) {
          console.log(result);
        }

      });
    this.responsive.observe(Breakpoints.TabletLandscape)
      .subscribe(result => {

        if (result.matches) {
          console.log("Tablette");
        }

      });
  }
}

