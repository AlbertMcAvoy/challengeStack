import {HttpClient, HttpHeaders, HttpParams} from "@angular/common/http";
import {catchError, Observable, of} from "rxjs";
import {Injectable} from "@angular/core";

@Injectable()
export class ApiService {

  private API_URL = 'https://localhost:8000';

  constructor(
    private http: HttpClient
  ) {}

  get(
    url: string,
    input?: any,
    txtResponse: boolean = false,
    jsonContentType: boolean = false,
    headers: { [headerKey: string]: string } = {},
  ): Observable<any> {

    let params: HttpParams = this.getHttpParams(input, false);
    let baseHeaders: HttpHeaders = this.getHeaders(false);
    let allHeaders: HttpHeaders = this.setAdditionalHeaders(baseHeaders, headers || {});
    let options = {headers: allHeaders, params: params};

    if (txtResponse) {
    }

    return this.http
      .get(`${this.API_URL}/${url}`, options)
      .pipe(
        catchError(error => this.handleError(error))
      );
  }

  post(
    url: string,
    input?: any,
    txtResponse: boolean = false,
    jsonContentType: boolean = true,
    myFitSession: boolean = true,
  ): Observable<any> {

    let params: HttpParams = this.getHttpParams(input, jsonContentType, myFitSession);
    let headers: HttpHeaders = this.getHeaders(jsonContentType);
    let options = { headers };

    if (txtResponse) {
    }

    return this.http
      .post(`${this.API_URL}/${url}`, jsonContentType ? input : params, options)
      .pipe(
        catchError(error => this.handleError(error))
      );
  }

  private getHttpParams(
    input: any,
    jsonContent: boolean = true,
    myFitSession: boolean = true,
  ): HttpParams {
    let params: HttpParams = new HttpParams();
    if (input && !jsonContent) {
      Object.keys(input).forEach((key) => params = params.append(key, input[key]));
    }
    if (myFitSession) {
      params = params.append('token', 'token');
    }
    return params;
  }

  private setAdditionalHeaders(baseHeaders: HttpHeaders, additionalHeaders: { [headerKey: string]: string }) {
    return Object.keys(additionalHeaders).reduce(
      (headers: HttpHeaders, nextHeaderKey: string) => {
        return headers.append(nextHeaderKey, additionalHeaders[nextHeaderKey]);
      },
      baseHeaders,
    );
  }

  private getHeaders(jsonContentType: boolean): HttpHeaders {
    return (jsonContentType) ?
      new HttpHeaders({'Content-Type': 'application/json', 'Authorization': `Bearer ${this.getJWT()}`}) :
      new HttpHeaders({'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'});
  }

  private getJWT(): string {
    let returnToken: string | null = sessionStorage.getItem('jwt');

    return returnToken == null ? '' : returnToken;
  }

  private handleError(error: any) {
    console.log(error)
    if (error.code == '401') {
      this.get(
        'auth/refresh',
        {
          'refresh_token': sessionStorage.getItem('refresh_token')
        }
      ).subscribe((data) => {
        sessionStorage.setItem('token', data.token);
        sessionStorage.setItem('refresh_token', data.refresh_token);
      })
    }
    return of(error);
  }
}
