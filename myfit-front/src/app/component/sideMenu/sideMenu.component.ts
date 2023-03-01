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
  selectedMeal: Array<any> = [];

  constructor(public dialog: MatDialog) {}

  openDialog(): void {
    const dialogRef = this.dialog.open(PopUpComponent , {
      height: '400px',
      width: '600px',
      data: {description: this.description}
    });

    dialogRef.afterClosed().subscribe(result => {
      this.selectedMeal = JSON.parse(localStorage.getItem('repas')!) ;
    });

  }
}
