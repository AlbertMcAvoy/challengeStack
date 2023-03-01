import {Component, Inject, OnInit} from '@angular/core';
import {MAT_DIALOG_DATA, MatDialogRef} from '@angular/material/dialog';
import {FormControl} from "@angular/forms";
import {map, Observable, startWith} from "rxjs";

export interface Meal {
  description: string;
}

@Component({
  selector: 'pop-up-component',
  templateUrl: 'popUp.component.html',
  styleUrls: ['popUp.component.scss']
})
export class PopUpComponent {
  constructor(
    public dialogRef: MatDialogRef<PopUpComponent>,
    @Inject(MAT_DIALOG_DATA) public newMeal: Meal,
  ) {}

  allMeals:Array<Meal> =
  [
    {'description' : 'Petit déjeuner - 650 cal.'},
    {'description': 'Déjeuner - 650 cal.'},
    {'description': 'Collation - 650 cal.'},
    {'description': 'Diner - 650 cal.'},
    {'description': 'Petit déjeuner - 650 cal.'}
  ];

  selectedMeal:Array<Meal> = [];

  addMeals(description: string) {
    let meal: Meal = { description: description}
    this.allMeals.push(meal);
  }

  get meals () {
    return this.allMeals;
  }

  myControl = new FormControl('');

  private _filter(value: string): string | undefined {
    const filterValue = value.toLowerCase();
    let found = this.meals.find(option => option.description.toLowerCase().includes(filterValue));
    return found?.description;
  }

  addMeal(meal: Meal) {
    this.selectedMeal.push(meal);
  }

  get selected() {
    return this.selectedMeal;
  }

  deleteMeal(meal: Meal)
  {
    let index = this.selectedMeal.findIndex(({ description }) => description === meal.description);
    if (index !== -1) {
      this.selectedMeal.splice(index, 1);
    }
  }

  submit() {
    localStorage.setItem('repas',JSON.stringify(this.selectedMeal))
    this.onNoClick()
  }

  onNoClick(): void {
    this.dialogRef.close();
  }
}
