import {Component, Inject, Input} from "@angular/core";
import {MAT_DIALOG_DATA, MatDialog} from "@angular/material/dialog";
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
export class SideMenuComponent {
  @Input() openSideMenu: boolean = false;
  panelOpenState = false;
  selectedMeal: Array<Meal> = [];
  selectedMealMenu: any = [];

  constructor(
    public dialog: MatDialog,
    private dao: DAO
  ) {
    this.retrieveMeal();
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

  openEditYesterdayFoodDialog(): void {
    const dialogRef = this.dialog.open(PopUpComponent , {
      height: '400px',
      width: '600px',
      data: {titleDialog: 'Editer un repas', button: 'Supprimer'}
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

}
