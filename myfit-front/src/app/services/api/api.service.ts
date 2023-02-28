import {HttpClient, HttpHeaders, HttpParams} from "@angular/common/http";
import {Observable} from "rxjs";
import {Injectable} from "@angular/core";

@Injectable()
export class ApiService {

  private API_URL = 'http://localhost:8000';

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
      .pipe();
  }

  post(
    url: string,
    input?: any,
    txtResponse: boolean = false,
    jsonContentType: boolean = true,
    disabledLogoutOn401: boolean = false,
    withInputAsQueryParams: boolean = true,
    myFitSession: boolean = true,
  ): Observable<any> {
    let params: HttpParams = this.getHttpParams(input, jsonContentType, myFitSession);
    let headers: HttpHeaders = this.getHeaders(jsonContentType);
    let options = {
      headers,
      ...(withInputAsQueryParams ? { params } : {}),
    };

    if (txtResponse) {
    }

    return this.http
      .post(`${this.API_URL}/${url}`, jsonContentType ? input : params, options)
      .pipe();
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
      new HttpHeaders({'Content-Type': 'application/json'}) :
      new HttpHeaders({'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'});
  }
}
