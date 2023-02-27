import {Component} from "@angular/core";
@Component({
  selector: 'register',
  templateUrl: 'registerPage-component.html',
  styleUrls: ['registerPage-component.scss']
})
export class RegisterPageComponent {
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
