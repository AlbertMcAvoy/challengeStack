import {Component, Input} from "@angular/core";
import {MatDialog} from "@angular/material/dialog";
import {PopUpComponent} from "../PopUp/popUp.component";

@Component({
  selector: 'side-menu',
  templateUrl: 'sideMenu.component.html',
  styleUrls: ['sideMenu.component.scss']
})
export class SideMenuComponent {
  @Input() openSideMenu: boolean = false;
  panelOpenState = false;
  description: string = "";
  titleForAddMeal : string = "Ajouter un repas";
  titleForEditMeal: string= "Editer un repas";
  selectedMeal: Array<any> = [];

  constructor(public dialog: MatDialog) {}

  openDialogForAddMeal(): void {
    const dialogRef = this.dialog.open(PopUpComponent , {
      height: '400px',
      width: '600px',
      data: {description: this.description, title : this.titleForAddMeal}
    });

    dialogRef.afterClosed().subscribe(result => {
      this.selectedMeal = JSON.parse(localStorage.getItem('repas')!) ;
    });
  }

  openDialogForEditMeal(): void {
    const dialogRef = this.dialog.open(PopUpComponent, {
      height: '400px',
      width: '600px',
      data: {description: this.description, title: this.titleForEditMeal}
    });

    dialogRef.afterClosed().subscribe(result => {
      this.selectedMeal = JSON.parse(localStorage.getItem('repas')!) ;
    });
  }

}
