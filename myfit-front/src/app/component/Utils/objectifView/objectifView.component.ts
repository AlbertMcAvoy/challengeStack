import {Component, Input, OnInit} from "@angular/core";
import {UserModel} from "../../../model/user.model";
import {DAO} from "../../../model/DAO";
import {firstValueFrom} from "rxjs";
import {Meal} from "../../../class/Meal";
import {HttpErrorResponse} from "@angular/common/http";
import {DatStoreService} from "../../../services/dataStore/datStore.service";

@Component({
  selector: 'objectif-view',
  templateUrl: 'objectifView.component.html',
  styleUrls: ['objectifView.component.scss']
})
export class ObjectifViewComponent implements  OnInit{

  @Input() user: UserModel | undefined;

  todayCalories: number = 0;
  homePage: boolean = false;
  selectedMeal: Array<Meal> = [];

  constructor(
    private dao: DAO,
    private dataStore: DatStoreService
  ) {
  }

  ngOnInit() {
    this.dataStore.totalCaloriesAsObservable.subscribe(calorie =>{
      this.todayCalories = calorie;
    });
    this.retrieveMeal();
  }

  retrieveMeal() {
    firstValueFrom(this.dao.retreiveUserMeals())
      .then((data) => {
        data.forEach((meal: Meal) => {
          meal.calorieTot = 0;
          meal.foods.forEach(food => {
            meal.calorieTot += food.calories;
          })
        });
        this.selectedMeal = data;
        this.loadTodayCalories();
      })
      .catch((e: HttpErrorResponse) => {
        console.log(e);
      });
  }

  getTotal(arrayMeal: Array<Meal>): number {
    let somme = 0;
    for (let i = 0; i < arrayMeal.length; i++) {
      somme += arrayMeal[i].calorieTot;
    }
    return somme;
  }

  private loadTodayCalories() {
    this.dataStore.totalCalories = this.getTotal(this.selectedMeal)
  }

}
