import {Component, Inject} from "@angular/core";
import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material/dialog";

@Component({
  selector: 'edit-user',
  templateUrl: 'editUserInfo.component.html',
  styleUrls: ['editUserInfo.component.scss']
})
export class EditUserInfoComponent {

  constructor(
    public dialogRef: MatDialogRef<EditUserInfoComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any,
  ) {}

  closePopup(): void {
    this.dialogRef.close();
  }

  registerForm: any;


  submit() {

  }
}
