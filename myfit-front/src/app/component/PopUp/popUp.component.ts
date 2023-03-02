import {Component, OnInit} from '@angular/core';
import {MatDialogRef} from '@angular/material/dialog';
import {firstValueFrom, map, Observable, startWith} from "rxjs";
import {DAO} from "../../model/DAO";
import {Meal} from "../../class/Meal";
import {Food} from "../../class/Food";
import {HttpErrorResponse} from "@angular/common/http";
import {FormControl} from "@angular/forms";

@Component({
  selector: 'pop-up-component',
  templateUrl: 'popUp.component.html',
  styleUrls: ['popUp.component.scss']
})
export class PopUpComponent implements OnInit{
  constructor(
    public dialogRef: MatDialogRef<PopUpComponent>,
    private dao : DAO
  ) {}

  mealName: string = '';

  allFoods: Array<Food> = [
    {
      'id' : 1000,
      'libelle' : 'Pastis 1',
      'calories': 520
    },
    {
      'id' : 1010,
      'libelle' : 'Pastis 2',
      'calories': 520
    },
    {
      'id' : 1019,
      'libelle' : 'Pastis 3',
      'calories': 520
    },
    {
      'id' : 1031,
      'libelle' : 'Pastis 4',
      'calories': 520
    }
  ];

  currentMeal: Meal = new Meal();

  myControl = new FormControl('');
  valueInputSearch: String = "";
  filteredOptions: Observable<Food[]> = new Observable<Food[]>();

  ngOnInit(): void {
    this.filteredOptions = this.myControl.valueChanges.pipe(
      startWith(''),
      map(value => this.filter(value || '')),
    );
  }

  get foods () {
    return this.allFoods;
  }

   private filter(value: string): Food[] {
     const filterValue = value.toLowerCase();
     return this.foods.filter(option => option.libelle.toLowerCase().includes(filterValue));
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
    if (this.mealName == '') return;
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
