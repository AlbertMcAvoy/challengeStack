import {Component, Input} from "@angular/core";
@Component({
  selector: 'menu-component',
  templateUrl: 'menu-component.html',
  styleUrls: ['menu-component.scss']
})
export class MenuComponent {

  @Input() redirectionPath: string | undefined;

  disconnect() {
    sessionStorage.clear();
    window.location.href = '/';
  }
}
