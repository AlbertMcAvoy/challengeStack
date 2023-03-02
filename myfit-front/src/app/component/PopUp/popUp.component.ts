import {Component} from '@angular/core';
import {MatDialogRef} from '@angular/material/dialog';
import {FormControl} from "@angular/forms";
import {firstValueFrom, map, Observable, startWith} from "rxjs";
import {DAO} from "../../model/DAO";
import {Meal} from "../../class/Meal";
import {Food} from "../../class/Food";
import {HttpErrorResponse} from "@angular/common/http";

@Component({
  selector: 'pop-up-component',
  templateUrl: 'popUp.component.html',
  styleUrls: ['popUp.component.scss']
})
export class PopUpComponent {
  constructor(
    public dialogRef: MatDialogRef<PopUpComponent>,
    private dao : DAO
  ) {}

  mealName: string = '';

  allFoods: Array<Food> = [
    {
      'id' : 1000,
      'description' : 'Pastis 1'
    },
    {
      'id' : 1010,
      'description' : 'Pastis 2'
    },
    {
      'id' : 1019,
      'description' : 'Pastis 3'
    },
    {
      'id' : 1031,
      'description' : 'Pastis 4'
    }
  ];

  currentMeal: Meal = new Meal();

  myControl = new FormControl('');

  get foods () {
    return this.allFoods;
  }

  private _filter(value: string): string | undefined {
    const filterValue = value.toLowerCase();
    let found = this.foods.find(option => option.description.toLowerCase().includes(filterValue));
    return found?.description;
  }

  addFood(food: Food) {
    this.currentMeal.foods.push(food);
  }

  get currentMealFoods() {
    return this.currentMeal.foods;
  }

  deleteFood(food: Food)
  {
    let index = this.currentMeal.foods.findIndex(({ id }) => id === food.id);

    if (index !== -1) {
      this.currentMeal.foods.splice(index, 1);
    }
  }

  submit() {
    this.currentMeal.name = this.mealName;
    firstValueFrom(this.dao.createNewMeal(this.currentMeal))
      .then(() => {
        this.onNoClick();
    }).catch((e: HttpErrorResponse) => {
      console.log(e);
      this.onNoClick();
    })
  }

  onNoClick(): void {
    this.dialogRef.close(this.currentMeal);
  }
}
