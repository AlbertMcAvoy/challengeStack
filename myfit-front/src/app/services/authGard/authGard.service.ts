import {Injectable} from "@angular/core";
import {ActivatedRouteSnapshot, CanActivate, Router, RouterStateSnapshot} from "@angular/router";

@Injectable({
  providedIn: 'root'
})
export class AuthGardService implements CanActivate{

  constructor(private _router:Router) {
  }

  canActivate(route: ActivatedRouteSnapshot,
              state: RouterStateSnapshot): boolean {

    if (sessionStorage.getItem('token') && sessionStorage.getItem('token') !== null)  {
      return true;
    }
    this._router.navigate(['**'])
    return false;
  }

}
