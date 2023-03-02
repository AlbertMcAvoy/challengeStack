import {Component, OnInit} from "@angular/core";
import {firstValueFrom} from "rxjs";
import {UserModel} from "../../model/user.model";
import {DAO} from "../../model/DAO";
import {MatDialog} from "@angular/material/dialog";
import {EditUserInfoComponent} from "../editInfoUser/editUserInfo.component";
import {GenreEnum} from "../../model/genreEnum";
import {DeleteUserPopUp} from "../deleteUserPopup/deleteUserPopUp";

@Component({
  selector: 'infoUser',
  templateUrl: 'infoUser.component.html',
  styleUrls: ['infoUser.component.scss']
})
export class InfoUserComponent implements OnInit{

  genre = GenreEnum;

  constructor(private dao: DAO, public dialog: MatDialog) {
  }

  editProfile: boolean = false;
  edit() {
    this.editProfile = !this.editProfile;
  }


  userInfo: UserModel = {
    age: '',
    firstname: '',
    gender: '0',
    height: 0,
    id: 0,
    lastname: '',
    objectif_weight: 0,
    subscription_date: '',
    weight: 0,
    phone: '',
    email: ''
  };

  ngOnInit() {
    this.getUser();
  }

  profileEmpty (): boolean {
    return this.userInfo.lastname != '' && this.userInfo.firstname != '';
  }

  openEditUserPopUp(): void {
    const dialogRef = this.dialog.open(EditUserInfoComponent , {
      data: this.userInfo,
    });

    dialogRef.afterClosed().subscribe(result => {
      console.log('The dialog was closed');
      this.getUser();
    });
  }

  getUser() {
    firstValueFrom(this.dao.getUser()).then(
      (res) => {
        this.userInfo = res;
      },
      (error) => {
      }
    )
  }

  deleteUser() {

    const dialogRef = this.dialog.open(DeleteUserPopUp , {
      data: this.userInfo,
    });

    dialogRef.afterClosed().subscribe(result => {
      console.log('The dialog was closed');
      this.getUser();
    });

  }

  getGender(): string {
    return this.genre[ parseInt(this.userInfo.gender)];
  }
}
