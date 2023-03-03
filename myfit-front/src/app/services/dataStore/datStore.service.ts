import {BehaviorSubject, Observable} from "rxjs";
import {Injectable} from "@angular/core";

@Injectable()
export class DatStoreService {

  private totalCaloriesObs: BehaviorSubject<number> = new BehaviorSubject<number>(0);

  get totalCaloriesAsObservable(): Observable<number> { return this.totalCaloriesObs.asObservable(); }
  get totalCalories(): number { return this.totalCaloriesObs.value; }
  set totalCalories(calorie: number) {this.totalCaloriesObs.next(calorie); }

  reset() { this.totalCaloriesObs.next(0); }
}


