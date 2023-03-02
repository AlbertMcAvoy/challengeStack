import {Component, Input} from "@angular/core";
import {UserModel} from "../../../model/user.model";
import {DAO} from "../../../model/DAO";

@Component({
  selector: 'objectif-view',
  templateUrl: 'objectifView.component.html',
  styleUrls: ['objectifView.component.scss']
})
export class ObjectifViewComponent {

  @Input() user: UserModel | undefined;

  todayCalories: number = 0;

  constructor(
    private dao: DAO
  ) {


  }
}
