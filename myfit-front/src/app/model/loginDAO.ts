import {ApiService} from "../services/api/api.service";
import {Observable} from "rxjs";
import {Injectable} from "@angular/core";

@Injectable()
export class LoginDAO {

  constructor(
    private apiService: ApiService
  ) {}

  connexion(data: object): Observable<any> {
    return this.apiService.post('auth/login', data);
  }

  inscription(data: object): Observable<any> {
    return this.apiService.post('auth/register', data);
  }
}
