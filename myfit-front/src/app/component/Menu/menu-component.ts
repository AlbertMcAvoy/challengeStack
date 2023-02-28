import {Component} from "@angular/core";
@Component({
  selector: 'menu-component',
  templateUrl: 'menu-component.html',
  styleUrls: ['menu-component.scss']
})
export class MenuComponent {
  redirectToLogin() {
    window.location.href = '/login';
  }
  redirectToHome() {
    window.location.href = '/';
  }
  redirectToProgram() {
    window.location.href = '/';
  }
}
