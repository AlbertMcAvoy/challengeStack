import {ApiService} from "../services/api/api.service";
import {Observable} from "rxjs";
import {Injectable} from "@angular/core";
import {Meal} from "../class/Meal";
import {User} from "../class/User";
import {UserModel} from "./user.model";
import {formatDate} from '@angular/common';

@Injectable()
export class DAO {

  constructor(
    private apiService: ApiService
  ) {}

  connexion(data: User): Observable<any> {
    return this.apiService.post('auth/login', data);
  }

  inscription(data: object): Observable<any> {
    return this.apiService.post('auth/register', data);
  }

  createNewMeal(meal: Meal): Observable<any> {

    let allIdFoods: number[] = [];

    meal.foods.forEach((food) => {allIdFoods.push(food.id)})

    return this.apiService.post(
      'api/meal/new',
      {
        'name': meal.name,
        'foods': allIdFoods
      });
  }

  retreiveUserMeals(): Observable<any> {
    return this.apiService.get('api/meal/user');
  }

  retreiveUserMealsToday(): Observable<any> {
    let today = formatDate(new Date(), 'YYYY-MM-dd', 'en');
    return this.apiService.get(`api/meal/date/${today}`);
  }

  getUser(): Observable<UserModel> {
    return this.apiService.get('api/user')
  }

  retreiveUserBodies(): Observable<any> {
    return this.apiService.get('api/body');
  }
}
