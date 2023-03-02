import {Component, Input} from "@angular/core";
import {UserModel} from "../../../model/user.model";
import {DAO} from "../../../model/DAO";
import {firstValueFrom} from "rxjs";
import {Meal} from "../../../class/Meal";
import {HttpErrorResponse} from "@angular/common/http";

@Component({
  selector: 'objectif-view',
  templateUrl: 'objectifView.component.html',
  styleUrls: ['objectifView.component.scss']
})
export class ObjectifViewComponent {

  @Input() user: UserModel | undefined;

  todayCalories: number = 0;

  constructor(
    private dao: DAO
  ) {
    firstValueFrom(this.dao.retreiveUserMealsToday())
      .then((data) => {
        data.forEach((meal: Meal) => {
          meal.calorieTot = 0;
          meal.foods.forEach(food => {
            this.todayCalories += food.calories;
          })
        });
      })
      .catch((e: HttpErrorResponse) => {
        console.log(e);
      });
  }
}
