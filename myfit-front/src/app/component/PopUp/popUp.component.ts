import {Component, Inject, OnInit} from '@angular/core';
import {MAT_DIALOG_DATA, MatDialogRef} from '@angular/material/dialog';
import {firstValueFrom, map, Observable, startWith} from "rxjs";
import {DAO} from "../../model/DAO";
import {Meal} from "../../class/Meal";
import {Food} from "../../class/Food";
import {HttpErrorResponse} from "@angular/common/http";
import {FormControl} from "@angular/forms";

export interface DialogData {
  titleDialog: string,
  selectedMealId: String,
  selectedMealName: String;
  selectedMealFood: Array<any>,
  selectedMealMenu: Meal
}

@Component({
  selector: 'pop-up-component',
  templateUrl: 'popUp.component.html',
  styleUrls: ['popUp.component.scss']
})
export class PopUpComponent implements OnInit{
  selectedMealId: String  = '';
  selectedMealName: String  = '';
  selectedMealFood: Array<any>  = [];
  selectedMealMenu: any;

  constructor(
    public dialogRef: MatDialogRef<PopUpComponent>,
    private dao : DAO,
    @Inject(MAT_DIALOG_DATA) public data: DialogData,
  ) {}

  mealName: string = '';
  allFoods: Array<Food> = [];
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
     let filterValue = value.toLowerCase();
     this.retreaveAllFoods(filterValue);
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
    if(this.data.titleDialog == 'Ajouter un repas') {
      firstValueFrom(this.dao.createNewMeal(this.currentMeal))
        .then(() => {
          this.onNoClick();
        }).catch((e: HttpErrorResponse) => {
        console.log(e);
        this.onNoClick();
      })
    } else {
      let dataForEdit = localStorage.getItem('dataForEdit');
      let data = JSON.parse(dataForEdit!);

      firstValueFrom(this.dao.editFood(data.id, this.mealName,[data.foods[0].id]))
        .then(() => {
          localStorage.removeItem('dataForEdit');
          this.onNoClick();
        }).catch((e: HttpErrorResponse) => {
        console.log(e);
        this.onNoClick();
      })
    }
  }

  retreaveAllFoods(value: string){
    firstValueFrom(this.dao.getFoods(value))
      .then((data) => {
        if (typeof (data['foods']) !== 'undefined')
          this.allFoods = data['foods'].slice(0, 10);
      })
      .catch((e: HttpErrorResponse) => {
        console.log(e);
      });
  }

  onNoClick(): void {
    this.dialogRef.close(this.currentMeal);
  }

}
