import {Component} from "@angular/core";

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
          text: 'Chart.js Line Chart - Cubic interpolation mode'
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

  ngOnInit() {
    const labels = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai','Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

    const datapoints = [0, 20, 20, 60, 60, 120, 180, 90, 80, 60, 60, 120];
    this.barChartData = {
      labels: labels,
      datasets: [
        {
          label: 'Cubic interpolation (monotone)',
          data: datapoints,
          fill: false,
          cubicInterpolationMode: 'monotone',
          tension: 0.4
        },
      ]
    };
  }
}
