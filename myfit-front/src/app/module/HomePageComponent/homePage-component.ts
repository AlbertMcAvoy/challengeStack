import {Component} from "@angular/core";
export interface BarChartDate {
  data: {
    datasets: { data: ({ x: string; y: number } | { x: string; y: number })[] }[]
  };
  type: string ;
}

@Component({
  selector: 'my-fit-log',
  templateUrl: 'homePage-component.html',
  styleUrls: ['homePage-component.scss']
})
export class HomePageComponent {

  domain = window.location.host;

  ngOnInit() {
    console.log(this.domain);
  }

}
