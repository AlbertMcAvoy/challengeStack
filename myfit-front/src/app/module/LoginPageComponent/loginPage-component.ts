import {Component, EventEmitter} from "@angular/core";
import {MatSnackBar} from "@angular/material/snack-bar";
import {FormBuilder, FormControl, FormGroup, Validators} from "@angular/forms";
import {firstValueFrom} from "rxjs";
import {HttpErrorResponse} from "@angular/common/http";
import {LoginDAO} from "../../model/loginDAO";

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

  updateMenuLinkViaParent: Function | undefined;

  constructor(
    private _snackBar: MatSnackBar,
    private fb: FormBuilder,
    private loginDAO: LoginDAO
  ) {
    this.userForm = this.fb.group({
      email : new FormControl('', Validators.compose([
        Validators.required,
        Validators.pattern('^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$')
      ])),
      password: new FormControl('', Validators.compose([
        Validators.required
      ]))
    });
  }

  submit() {
    if (this.userForm.get('email')?.status == 'INVALID') {
      this._snackBar.open('Le mot de passe ou le mail ne sont pas bons', 'OK',{
        horizontalPosition: 'center',
        verticalPosition: 'top'
      });
      this.clear();
    }

    this.email = this.userForm.get('email')?.value; // input value retrieved
    this.password = this.userForm.get('password')?.value; // input value retrieved

    firstValueFrom(this.loginDAO.connexion({
      'username': this.email,
      'password': this.password
    })).then((data) => {
      sessionStorage.setItem('jwt', data.token);
      window.location.href = '/compte';
      if (this.updateMenuLinkViaParent) {
        this.updateMenuLinkViaParent();
      }
    }).catch((e: HttpErrorResponse) => {
      let snackBarRef = this._snackBar.open('Une erreur s\'est produite, réessayez plus tard !', 'OK',{
        horizontalPosition: 'center',
        verticalPosition: 'top'
      });

      console.log(e);

      snackBarRef.onAction().subscribe(() => {
        this.clear();
      });
    });
  }

  clear(){
    this.userForm.reset();
    this.show = true;
  }
}
