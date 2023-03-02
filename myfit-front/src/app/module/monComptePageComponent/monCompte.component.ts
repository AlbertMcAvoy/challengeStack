import {Component} from "@angular/core";

@Component({
  selector: 'mon-compte',
  templateUrl: 'monCompte.component.html',
  styleUrls: ['monCompte.component.scss']
})
export class MonCompteComponent {
  openSideMenu: boolean = false;

  openMenu() {
    this.openSideMenu = !this.openSideMenu;
  }
}
