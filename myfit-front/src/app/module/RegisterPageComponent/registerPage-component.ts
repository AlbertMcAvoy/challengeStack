import {Component} from "@angular/core";
import {MatSnackBar} from "@angular/material/snack-bar";

@Component({
  selector: 'register',
  templateUrl: 'registerPage-component.html',
  styleUrls: ['registerPage-component.scss']
})
export class RegisterPageComponent {
  email : string ="";
  password : string ="";
  show: boolean= false;
  constructor(private _snackBar: MatSnackBar) {}

  submit(){
    this._snackBar.open('Merci pour votre inscription', 'OK');
    this.clear();
  }

  clear(){
    this.email ="";
    this.password = "";
    this.show = true;
  }

}
