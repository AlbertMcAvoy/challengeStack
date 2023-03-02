import {Component} from "@angular/core";

@Component({
  selector: 'infoUser',
  templateUrl: 'infoUser.component.html',
  styleUrls: ['infoUser.component.scss']
})
export class InfoUserComponent {

  editProfile: boolean = false;
  edit() {
    this.editProfile = !this.editProfile;
  }
}
