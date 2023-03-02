import {Component, Input} from "@angular/core";
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
export class SideMenuComponent {
  @Input() openSideMenu: boolean = false;
  panelOpenState = false;
  description: string = "";
  selectedMeal: Array<Meal> = [];

  constructor(
    public dialog: MatDialog,
    private dao: DAO
  ) {

    firstValueFrom(this.dao.retreiveUserMeals())
      .then((data) => {
        this.selectedMeal = data;
      })
      .catch((e: HttpErrorResponse) => {
        console.log(e);
      });
  }

  openDialog(): void {
    const dialogRef = this.dialog.open(PopUpComponent , {
      height: '400px',
      width: '600px',
      data: {description: this.description}
    });

    dialogRef.afterClosed().subscribe(result => {
      if (result == undefined ||
        result.name == ''
      ) return;

      this.selectedMeal.push(result);
    });
  }
}
