import {Component, Input} from "@angular/core";
import {User} from "../../../class/User";

@Component({
  selector: 'objectif-view',
  templateUrl: 'objectifView.component.html',
  styleUrls: ['objectifView.component.scss']
})
export class ObjectifViewComponent {

  @Input() user: User | undefined;
}
