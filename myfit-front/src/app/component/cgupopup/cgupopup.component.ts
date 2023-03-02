import { Component } from '@angular/core';
import {MatDialogRef} from "@angular/material/dialog";

@Component({
  selector: 'app-cgupopup',
  templateUrl: './cgupopup.component.html',
  styleUrls: ['./cgupopup.component.scss']
})
export class CGUPopupComponent {

  constructor(
    public dialogRef: MatDialogRef<CGUPopupComponent>,
  ) {}

  close() {
    this.dialogRef.close();
  }
}
