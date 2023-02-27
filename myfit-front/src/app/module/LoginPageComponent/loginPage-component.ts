import {Component} from "@angular/core";
@Component({
  selector: 'login',
  templateUrl: 'loginPage-component.html',
  styleUrls: ['loginPage-component.scss']
})
export class LoginPageComponent {
  email : string ="";
  password : string ="";
  show: boolean= false;
  submit(){
    console.log("user name is " + this.email)
    this.clear();
  }
  clear(){
    this.email ="";
    this.password = "";
    this.show = true;
  }
}
