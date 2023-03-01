import {Component, EventEmitter, Output} from "@angular/core";
@Component({
  selector: 'menu-component',
  templateUrl: 'menu-component.html',
  styleUrls: ['menu-component.scss']
})
export class MenuComponent {

  @Output() openSideMenu: EventEmitter<boolean> = new  EventEmitter<boolean>();

  openSideMenuClicked() {
    this.openSideMenu.emit(true);
  }
}
