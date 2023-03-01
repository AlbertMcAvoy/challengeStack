import {Component, Input} from "@angular/core";
import {Component, EventEmitter, Output} from "@angular/core";
@Component({
  selector: 'menu-component',
  templateUrl: 'menu-component.html',
  styleUrls: ['menu-component.scss']
})
export class MenuComponent {

  @Input() redirectionPath: string | undefined;

  @Output() openSideMenu: EventEmitter<boolean> = new  EventEmitter<boolean>();

  openSideMenuClicked() {
    this.openSideMenu.emit(true);
  }
  disconnect() {
    sessionStorage.clear();
    window.location.href = '/';
  }
}
