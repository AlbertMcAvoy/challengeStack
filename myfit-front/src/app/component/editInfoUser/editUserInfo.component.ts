import {Component, Inject, OnInit} from "@angular/core";
import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material/dialog";
import {GenreEnum} from "../../model/genreEnum";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {UserModel} from "../../model/user.model";

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

  nom =  this.fb.control('', [Validators.required]);
  prenom = this.fb.control('',[Validators.required]);
  age = this.fb.control('',[Validators.required]);
  genre = this.fb.control('',[Validators.required]);
  phone = this.fb.control('',[Validators.required]);
  taille = this.fb.control('',[Validators.required]);
  objectifPoid = this.fb.control('',[Validators.required]);
  poids = this.fb.control('',[Validators.required]);
  email = this.fb.control('',[Validators.required]);

  constructor(
    public dialogRef: MatDialogRef<EditUserInfoComponent>,
    @Inject(MAT_DIALOG_DATA) public data: UserModel,
    private fb: FormBuilder
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

  getUserPayload(): UserModel {
    this.dialogRef.close();
    return {
      age: this.age.value ?? '',
      firstname: this.prenom.value ?? '',
      gender: parseInt(this.genre.value ?? ''),
      height: this.data.height,
      id: this.data.id,
      lastname: this.nom.value ?? '',
      objectif_weight: parseInt(this.objectifPoid.value ?? ''),
      subscription_date: this.data.subscription_date,
      weight: parseInt(this.poids.value ?? '') ,
      phone: this.phone.value ?? '',
      email: this.data.email,
    }
  }
  initUserInfo() {
    this.userInforGroup.setValue({
      nom: this.data.lastname ?? '',
      prenom: this.data.firstname ?? '',
      age: this.data.age ?? '',
      genre: this.data.gender ?? '',
      phone: this.data.phone ?? '',
      taille: this.data.height ?? '',
      objectifPoid: this.data.objectif_weight ?? '',
      poids: this.data.weight ?? '',
      email: this.data.email ?? '',
    });
  }
}
