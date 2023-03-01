import {Component} from "@angular/core";

@Component({
  selector: 'profile-utilisateur',
  templateUrl: 'profileUtilisateur.component.html',
  styleUrls: ['profileUtilisateur.component.scss']
})
export class ProfileUtilisateurComponent {

  editProfile: boolean = false;
  edit() {
    this.editProfile = !this.editProfile;
  }
}
