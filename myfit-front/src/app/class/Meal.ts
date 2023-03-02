import {Food} from "./Food";

export class Meal {

  id : string = '';

  name: string = '';

  foods: Array<Food> = [];

  calorieTot: number = 0;
}
