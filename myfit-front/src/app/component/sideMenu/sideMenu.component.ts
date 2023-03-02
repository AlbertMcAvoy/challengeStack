import {Component, Input, OnInit} from "@angular/core";
import {MatDialog} from "@angular/material/dialog";
import {PopUpComponent} from "../PopUp/popUp.component";
import {Meal} from "../../class/Meal";
import {DAO} from "../../model/DAO";
import {firstValueFrom} from "rxjs";
import {HttpErrorResponse} from "@angular/common/http";


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
  selectedMealId: string= '';

  constructor(
    public dialog: MatDialog,
    private dao: DAO
  ) {
    this.retrieveMeal();
  }

  ngOnInit() {
    this.retrieveTodayMeal();
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

  openAddEditFoodDialog(meal: Meal): void {
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
        debugger;
        data.forEach((meal: Meal) => {
          meal.calorieTot = 0;
          meal.foods.forEach(food => {
            meal.calorieTot += food.calories;
          })
        });
      })
      .catch((e: HttpErrorResponse) => {
        console.log(e);
        this.retrieveMeal();
      });
  }



  deleteMeal(id: String) {
    firstValueFrom(this.dao.deleteFood(id))
      .then((data) => {
        console.log(data);
        this.retrieveMeal();
      })
      .catch((e: HttpErrorResponse) => {
        console.log(e);
      });
  }

  retrieveTodayMeal() {
    firstValueFrom(this.dao.retreiveUserMealsToday()).then(
      (data) => {
        console.log(data)
        this.selectedMeal = data;
      },
      (error) => {

      }
    )
  }

  retrieveYesterdayMeal() {
    firstValueFrom(this.dao.retrieveUserMealsYesterday()).then(
      (data) => {
        console.log(data)
        this.yesterdayMeal = data;
      },
      (error) => {

      }
    )
  }

  retrieveBeforeYesterdayMeal() {
    firstValueFrom(this.dao.retrieveUserMealsBeforeYesterday()).then(
      (data) => {
        console.log(data);
        this.beforeYesterdayMeal = data
      },
      (error) => {

      }
    )
  }

}
