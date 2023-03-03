import {ChangeDetectorRef, Component, Inject, Input, OnInit} from "@angular/core";
import {MatDialog} from "@angular/material/dialog";
import {PopUpComponent} from "../PopUp/popUp.component";
import {Meal} from "../../class/Meal";
import {DAO} from "../../model/DAO";
import {firstValueFrom} from "rxjs";
import {HttpErrorResponse} from "@angular/common/http";
import {DatStoreService} from "../../services/dataStore/datStore.service";


@Component({
  selector: 'side-menu',
  templateUrl: 'sideMenu.component.html',
  styleUrls: ['sideMenu.component.scss']
})
export class SideMenuComponent implements OnInit{
  @Input() openSideMenu: boolean = false;
  panelOpenState = false;
  selectedMeal: Array<Meal> = [];
  yesterdayMeal: Array<Meal> = [];
  beforeYesterdayMeal: Array<Meal> = [];
  selectedMealMenu: any = [];

  constructor(
    public dialog: MatDialog,
    private dao: DAO,
    private dataStore: DatStoreService,
    private cdr: ChangeDetectorRef
  ) {
    this.retrieveMeal();
  }

  ngOnInit() {
    this.retrieveYesterdayMeal();
    this.retrieveBeforeYesterdayMeal();
  }

  openAddFoodDialog(): void {
    const dialogRef = this.dialog.open(PopUpComponent , {
      height: '400px',
      width: '600px',
      data: {titleDialog: 'Ajouter un repas'}
    });

    dialogRef.afterClosed().subscribe(result => {
      if (result == undefined ||
        result.name == ''
      ) return;
      this.retrieveMeal();
    });
  }

  openEditFoodDialog(meal: Meal): void {
    localStorage.setItem('dataForEdit',JSON.stringify(meal));
    this.selectedMealMenu = meal;
    const dialogRef = this.dialog.open(PopUpComponent , {
      height: '400px',
      width: '600px',
      data: {titleDialog: 'Editer un repas'}
    });

    dialogRef.afterClosed().subscribe(result => {
      if (result == undefined ||
        result.name == ''
      ) return;
      this.retrieveMeal();
    });
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
        this.cdr.markForCheck();
      })
      .catch((e: HttpErrorResponse) => {
        console.log(e);
      });
  }

  deleteMeal(id: String) {
    firstValueFrom(this.dao.deleteFood(id))
      .then((data) => {
        console.log(data);
        this.retrieveMeal();
        this.loadTodayCalories();
        this.cdr.markForCheck();
      })
      .catch((e: HttpErrorResponse) => {
        console.log(e);
      });
  }

  retrieveYesterdayMeal() {
    firstValueFrom(this.dao.retrieveUserMealsYesterday()).then(
      (data) => {
        data.forEach((meal) => {
          this.dao.getMealInfo
          firstValueFrom(this.dao.getMealInfo(meal.id)).then(
            (value: Meal) => {
              meal.calorieTot = 0;
              value.foods.forEach(food => {
                meal.calorieTot += food.calories;
              })
            }
          )
        })
        this.yesterdayMeal = data;
      },
      (error) => {

      }
    )
  }

  retrieveBeforeYesterdayMeal() {
    firstValueFrom(this.dao.retrieveUserMealsBeforeYesterday()).then(
      (data) => {
        data.forEach((meal: Meal) => {
          meal.calorieTot = 0;
          meal.foods.forEach(food => {
            meal.calorieTot += food.calories;
          })
        });
        this.beforeYesterdayMeal = data
      },
      (error) => {

      }
    )
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
