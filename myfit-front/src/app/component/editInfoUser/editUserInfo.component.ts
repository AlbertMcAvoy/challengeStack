import {Component, Inject, OnInit} from "@angular/core";
import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material/dialog";
import {GenreEnum} from "../../model/genreEnum";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {UserModel} from "../../model/user.model";
import {DAO} from "../../model/DAO";
import {firstValueFrom} from "rxjs";
import {MatSnackBar} from "@angular/material/snack-bar";

@Component({
  selector: 'edit-user',
  templateUrl: 'editUserInfo.component.html',
  styleUrls: ['editUserInfo.component.scss']
})
export class EditUserInfoComponent implements OnInit{


  password : string = "";
  show: boolean = false;
  sexEnum = GenreEnum;

  userInforGroup: FormGroup;

  nom =  this.fb.control('');
  prenom = this.fb.control('');
  age = this.fb.control('');
  genre = this.fb.control('');
  phone = this.fb.control('');
  taille = this.fb.control('');
  objectifPoid = this.fb.control('');
  poids = this.fb.control('');
  email = this.fb.control('');

  constructor(
    public dialogRef: MatDialogRef<EditUserInfoComponent>,
    @Inject(MAT_DIALOG_DATA) public data: UserModel,
    private fb: FormBuilder,
    private dao: DAO,
    private _snackBar: MatSnackBar,
  ) {
    this.userInforGroup = this.fb.group({
      nom: this.nom,
      prenom: this.prenom,
      age: this.age,
      genre: this.genre,
      phone: this.phone,
      taille: this.taille,
      objectifPoid: this.objectifPoid,
      poids: this.poids,
      email: this.email,
    })

    this.initUserInfo();
  }

  ngOnInit() {
    this.userInforGroup.valueChanges.subscribe((value) => {
      console.log(value);
    })
  }

  closePopup(): void {
    this.dialogRef.close();
  }

  registerForm: any;


  submit() {

  }

  updateUser() {

    firstValueFrom(this.dao.updateUser(this.getUserPayload())).then(
        (value) => {
          this._snackBar.open('Vos information ont été mise à jour', 'OK',{
            horizontalPosition: 'center',
            verticalPosition: 'top'
          });

          setTimeout(() => {
            this._snackBar.dismiss();
          },3000);
        },
        () => {
          this._snackBar.open('Une erreur s\'est produite, réessayez plus tard !', 'OK',{
            horizontalPosition: 'center',
            verticalPosition: 'top'
          });

          setTimeout(() => {
            this._snackBar.dismiss();
          },3000);
        },
      ).then(
      () => {
        this.dialogRef.close();
      }
    )
  }

  getUserPayload(): UserModel {
    return {
      age: this.age.value ?? '',
      firstname: this.prenom.value ?? '',
      gender: this.genre.value ?? '',
      height: parseInt(this.taille.value ?? ''),
      id: this.data.id,
      lastname: this.nom.value ?? '',
      objectif_weight: parseInt(this.objectifPoid.value ?? ''),
      subscription_date: this.data.subscription_date,
      weight: parseInt(this.poids.value ?? '') ,
      phone: this.phone.value ?? '',
    }
  }
  initUserInfo() {
    console.log(this.data);
    this.userInforGroup.setValue({
      nom: this.data.lastname ?? '',
      prenom: this.data.firstname ?? '',
      age: this.data.age ?? '',
      genre: 0,
      phone: this.data.phone ?? '',
      taille: this.data.height ?? '',
      objectifPoid: this.data.objectif_weight ?? '',
      poids: this.data.weight ?? '',
      email: this.data.email ?? '',
    });
  }
}
