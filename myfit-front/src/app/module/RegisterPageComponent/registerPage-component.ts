import {Component} from "@angular/core";
import {MatSnackBar} from "@angular/material/snack-bar";
import {FormBuilder, FormControl, FormGroup, Validators} from "@angular/forms";

@Component({
  selector: 'register',
  templateUrl: 'registerPage-component.html',
  styleUrls: ['registerPage-component.scss']
})
export class RegisterPageComponent {
  nom : string = "";
  prenom : string = "";
  age : number = 0;
  genre : string = "Homme";
  phone : string = "";
  taille : string = "";
  poids : string = "";
  email : string = "";
  password : string = "";
  show: boolean = false;
  public registerForm:FormGroup; // variable is created of type FormGroup is created

  constructor(private _snackBar: MatSnackBar, private fb: FormBuilder) {
    this.registerForm = this.fb.group({
      nom : new FormControl('', Validators.compose([
        Validators.required
      ])),
      prenom : new FormControl('', Validators.compose([
        Validators.required
      ])),
      age : new FormControl('', Validators.compose([
        Validators.required
      ])),
      genre : new FormControl('', Validators.compose([
        Validators.required
      ])),
      phone : new FormControl('', Validators.compose([
        Validators.required
      ])),
      taille : new FormControl('', Validators.compose([
        Validators.required
      ])),
      poids : new FormControl('', Validators.compose([
        Validators.required
      ])),
      email : new FormControl('', Validators.compose([
        Validators.required,
        Validators.pattern('^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$')
      ])),
      password: new FormControl('', Validators.compose([
        Validators.required
      ]))
    });
  }

  submit(){
    for (let key in this.registerForm?.controls)
    {
      let status = this.registerForm?.controls[key].status;
      if ( status == 'INVALID') {
        this._snackBar.open('Veuillez-nous informer de votre ' + key , 'OK', {
            horizontalPosition: 'center',
            verticalPosition: 'top'
          }
        );
        return;
      }
    }

    let snackBarRef = this._snackBar.open('Merci, pour votre inscription', 'OK',{
      horizontalPosition: 'center',
      verticalPosition: 'top'
    });
    snackBarRef.onAction().subscribe(() => {
      window.location.href = '/login';
    });


    //data
    this.email = this.registerForm.get('email')?.value; // input value retrieved
    this.password = this.registerForm.get('password')?.value; // input value retrieved
    this.nom = this.registerForm.get('nom')?.value;
    this.prenom = this.registerForm.get('prenom')?.value;
    this.age = this.registerForm.get('age')?.value;
    this.genre = this.registerForm.get('genre')?.value;
    this.phone = this.registerForm.get('phone')?.value;
    this.taille = this.registerForm.get('taille')?.value;
    this.poids = this.registerForm.get('poids')?.value;

  }

  clear(){
    this.registerForm.reset();
    this.show = true;
  }

}
