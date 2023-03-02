import {Component, OnInit} from "@angular/core";
import {DAO} from "../../model/DAO";
import {firstValueFrom} from "rxjs";
import {UserModel} from "../../model/user.model";

@Component({
  selector: 'mon-compte',
  templateUrl: 'monCompte.component.html',
  styleUrls: ['monCompte.component.scss']
})
export class MonCompteComponent implements OnInit{
  openSideMenu: boolean = false;

  userInfo: UserModel = {
    age: '',
    firstname: '',
    gender: 0,
    height: 0,
    id: 0,
    lastname: '',
    objectif_weight: '',
    subscription_date: '',
    weight: 0,
    phone: '',
    email: ''
  };
  openMenu() {
    this.openSideMenu = !this.openSideMenu;
  }
  constructor(
    private dao: DAO
  ) {
  }
  ngOnInit() {
    firstValueFrom(this.dao.getUser()).then(
      (res) => {
        this.userInfo = res;
      },
      (error) => {
      }
    )
  }

}
