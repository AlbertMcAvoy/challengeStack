import { Component } from '@angular/core';
import {MatDialogRef} from "@angular/material/dialog";

@Component({
  selector: 'app-rgpdpopup',
  templateUrl: './rgpdpopup.component.html',
  styleUrls: ['./rgpdpopup.component.scss']
})
export class RGPDPopupComponent {

  constructor(
    public dialogRef: MatDialogRef<RGPDPopupComponent>,
  ) {}

  close() {
    this.dialogRef.close();
  }
}
