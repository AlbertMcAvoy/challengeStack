import {Component, Inject, OnInit} from '@angular/core';
import {MAT_DIALOG_DATA, MatDialogRef} from '@angular/material/dialog';
import {FormControl} from "@angular/forms";
import {map, Observable, startWith} from "rxjs";

export interface Meal {
  description: string;
  title : string;
}

@Component({
  selector: 'pop-up-component',
  templateUrl: 'popUp.component.html',
  styleUrls: ['popUp.component.scss']
})
export class PopUpComponent implements OnInit{
  constructor(
    public dialogRef: MatDialogRef<PopUpComponent>,
    @Inject(MAT_DIALOG_DATA) public data: Meal,
  ) {}


  allMeals:Array<Meal> =
    [
      {'description' : 'Petit déjeuner - 650 cal.' , 'title' : ''},
      {'description': 'Déjeuner - 650 cal.', 'title' : ''},
      {'description': 'Collation - 650 cal.', 'title' : ''},
      {'description': 'Diner - 650 cal.', 'title' : ''},
      {'description': 'Petit déjeuner - 650 cal.', 'title' : ''}
    ];

  selectedMeal:Array<Meal> = [];

  addMeals(description: string) {
    let meal: Meal = { description: description, title: '' }
    this.allMeals.push(meal);
  }

  get meals () {
    return this.allMeals;
  }

  myControl = new FormControl('');
  valueInputSearch: String = "";
  filteredOptions: Observable<Meal[]> = new Observable<Meal[]>();

  ngOnInit(): void {
    this.filteredOptions = this.myControl.valueChanges.pipe(
      startWith(''),
      map(value => this.filter(value || '')),
    );
  }

   private filter(value: string): Meal[] {
     const filterValue = value.toLowerCase();
     return this.meals.filter(option => option.description.toLowerCase().includes(filterValue));
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
