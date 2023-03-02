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
  homePage: boolean = false;

  constructor(
    private dao: DAO
  ) {
    this.loadTodayCalories();
  }

  private loadTodayCalories() {
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
        this.todayCalories = 2255;
        this.homePage = true;
        console.log(e);
      });
  }
}
