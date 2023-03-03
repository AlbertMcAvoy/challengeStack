import { Component } from '@angular/core';
import {RGPDPopupComponent} from "../../rgpdpopup/rgpdpopup.component";
import {MatDialog} from "@angular/material/dialog";
import {CGUPopupComponent} from "../../cgupopup/cgupopup.component";

@Component({
  selector: 'app-footer',
  templateUrl: './footer.component.html',
  styleUrls: ['./footer.component.scss']
})
export class FooterComponent {

  constructor(
    public dialog: MatDialog,
  ) {}

  triggerRGPDPopup() {
    this.dialog.open(RGPDPopupComponent , {
      height: 'auto',
      width: '600px',
    });
  }

  triggerCGUPopup() {
    this.dialog.open(CGUPopupComponent , {
      height: 'auto',
      width: '600px',
    });
  }
}
