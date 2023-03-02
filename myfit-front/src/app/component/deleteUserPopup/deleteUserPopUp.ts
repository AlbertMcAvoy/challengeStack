import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material/dialog";
import {Component, Inject} from "@angular/core";
import {UserModel} from "../../model/user.model";
import {firstValueFrom} from "rxjs";
import {DAO} from "../../model/DAO";
@Component({
  selector: 'deletePopup',
  templateUrl: 'deleteUserPopUp.html',
  styleUrls: ['deleteUserPopUp.scss'],
})
export class DeleteUserPopUp{
  constructor(
    public dialogRef: MatDialogRef<DeleteUserPopUp>,
    @Inject(MAT_DIALOG_DATA) public data: UserModel,
    private dao: DAO,
  ) {}

  close() {
    this.dialogRef.close();
  }

  updateUser() {
    firstValueFrom(this.dao.deleteUser()).then(
      (value) => {
        console.log(value);
        sessionStorage.clear();
        this.close();
        window.location.href = '/';
      }
    ),
      () => {
        console.log('non')
      }
  }
}
