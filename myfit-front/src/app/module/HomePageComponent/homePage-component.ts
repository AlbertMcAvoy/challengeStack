import {Component, OnInit} from "@angular/core";
@Component({
  selector: 'my-fit-log',
  templateUrl: 'homePage-component.html',
  styleUrls: ['homePage-component.scss']
})
export class HomePageComponent implements OnInit{

  domain = window.location.host;

  ngOnInit() {
    console.log(this.domain);
  }
}
