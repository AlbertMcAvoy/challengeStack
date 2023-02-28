import {Component} from "@angular/core";
import {MatSnackBar} from "@angular/material/snack-bar";
import {FormBuilder, FormControl, FormGroup, Validators} from "@angular/forms";

@Component({
  selector: 'login',
  templateUrl: 'loginPage-component.html',
  styleUrls: ['loginPage-component.scss']
})

export class LoginPageComponent {
  email: string = "";
  password: string = "";
  show: boolean = false;

  public userForm:FormGroup; // variable is created of type FormGroup is created
  constructor(private _snackBar: MatSnackBar, private fb: FormBuilder) {
    this.userForm = this.fb.group({
      email : new FormControl('', Validators.compose([
        Validators.required,
        Validators.pattern('^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$')
      ])),
      password: ''
    });
  }

  submit() {
    if (this.userForm.get('email')?.status == 'INVALID') {
      this._snackBar.open('Le mot de passe ou le mail ne sont pas bons', 'OK');
      this.clear();
    }
    this.email = this.userForm.get('email')?.value; // input value retrieved
    this.password = this.userForm.get('password')?.value; // input value retrieved
  }

  clear(){
    this.userForm.reset();
    this.show = true;
  }
}
