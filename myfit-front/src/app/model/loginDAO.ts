import {ApiService} from "../services/api/api.service";
import {Observable} from "rxjs";

export class LoginDAO {

  constructor(
    private apiService: ApiService
  ) {}

  connexion(): Observable<any> {
    return this.apiService.get('')
  }

  inscription(): Observable<any> {
    return this.apiService.post('');
  }
}
