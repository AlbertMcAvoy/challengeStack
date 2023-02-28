import {ApiService} from "../services/api/api.service";
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";

export class LoginDAO {

  api: ApiService;
  constructor() {
    this.api = new ApiService(new HttpClient())
  }

  connexion(): Observable<any> {
    return this.api.get('')
  }
  inscription(): Observable<any> {
    return this.api.post('');
  }
}
