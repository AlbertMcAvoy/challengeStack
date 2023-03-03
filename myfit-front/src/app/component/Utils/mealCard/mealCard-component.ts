import {Component, Input} from "@angular/core";

@Component({
  selector: 'mealCard',
  templateUrl: 'mealCard-component.html',
  styleUrls: ['mealCard-component.scss'],
})
export class MealCardComponent {
  @Input() mealToday: boolean = false;
  panelOpenState = false;
}
