import {Component} from "@angular/core";
import {DAO} from "../../../model/DAO";
import {firstValueFrom} from "rxjs";
import {HttpErrorResponse} from "@angular/common/http";

@Component({
  selector: 'graphique-evolution',
  templateUrl: 'graphiqueEvolution.component.html',
  styleUrls: ['graphiqueEvolution.component.scss']
})
export class GraphiqueEvolutionComponent {
  barChartData: any = null
  barChartOptions: any = {
    type: 'line',
    options: {
      responsive: true,
      plugins: {
        title: {
          display: true,
          text: 'Chart.js Line Chart - Courbe d\'évolution de votre poids'
        },
      },
      interaction: {
        intersect: false,
      },
      scales: {
        x: {
          display: true,
          title: {
            display: true
          }
        },
        y: {
          display: true,
          title: {
            display: true,
            text: 'Value'
          },
          suggestedMin: -10,
          suggestedMax: 200
        }
      }
    },

  }

  private defaultLabels: string[] = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai','Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
  private defaultWeight: number[] = [0, 20, 20, 60, 60, 120, 180, 90, 80, 60, 60, 120];

  constructor(
    private dao: DAO
  ) {}

  ngOnInit() {

    let labels: string[];
    let weight: number[];

    firstValueFrom(this.dao.retreiveUserBodies())
      .then(data => {

        data.forEach((body: any) => {
          labels.push(body.date);
          weight.push(body.weight);
        });

        this.barChartData = {
          labels: (labels.length > 0) ? labels : this.defaultLabels,
          datasets: [
            {
              label: 'Courbe d\'évolution de votre poids',
              data: (weight.length > 0) ? weight : this.defaultWeight,
              fill: false,
              cubicInterpolationMode: 'monotone',
              tension: 0.1
            },
          ]
        };
      }).catch((e: HttpErrorResponse) => {
      console.log(e)
    });
  }
}
