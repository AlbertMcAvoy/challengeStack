import {Component, Input} from "@angular/core";
import {MatDialog} from "@angular/material/dialog";
import {PopUpComponent} from "../PopUp/popUp.component";

@Component({
  selector: 'side-menu',
  templateUrl: 'sideMenu.component.html',
  styleUrls: ['sideMenu.component.scss']
})
export class SideMenuComponent {
  @Input() mealToday: boolean = false;
  panelOpenState = false;
  description: string = "";

  constructor(public dialog: MatDialog) {}

  openDialog(): void {
    const dialogRef = this.dialog.open(PopUpComponent , {
      height: '400px',
      width: '600px',
      data: {description: this.description},
    });

    dialogRef.afterClosed().subscribe(result => {
      this.description = result;
    });
  }
}
