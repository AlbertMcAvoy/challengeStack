import {Component, Input} from "@angular/core";

@Component({
  selector: 'side-menu',
  templateUrl: 'sideMenu.component.html',
  styleUrls: ['sideMenu.component.scss']
})
export class SideMenuComponent {
  @Input() mealToday: boolean = false;
  panelOpenState = false;
}
