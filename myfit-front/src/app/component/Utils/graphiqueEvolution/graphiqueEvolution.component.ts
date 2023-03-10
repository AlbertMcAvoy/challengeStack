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

  private defaultLabels: string[] = ['20/01/2023', '26/01/2023', '05/02/2023', '15/02/2023', '25/02/2023','03/03/2023'];
  private defaultWeight: number[] = [61, 63, 65, 68, 72,];
  weightLess: number = 0;

  constructor(
    private dao: DAO
  ) {
    this.retreiveUserBodies();
  }

  retreiveUserBodies() {
    let labels: string[] = [];
    let weight: number[] = [];

    firstValueFrom(this.dao.retreiveUserBodies())
      .then(data => {

        data.forEach((body: any) => {
          labels.push(new Date(body.date).toLocaleDateString());
          weight.push(body.weight);
        });

        this.weightLess = (data.length != 0) ? data.at(-1).objectif_weight - data.at(-1).weight : -1;

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

      })
      .catch((e: HttpErrorResponse) => {
        console.log(e)
        this.weightLess = 3;

        this.barChartData = {
          labels: this.defaultLabels,
          datasets: [
            {
              label: 'Courbe d\'évolution de votre poids',
              data: this.defaultWeight,
              fill: false,
              cubicInterpolationMode: 'monotone',
              tension: 0.1
            },
          ]
        };
      });
  }
}
