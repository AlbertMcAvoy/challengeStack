import {Component, OnInit} from "@angular/core";
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
export class HomePageComponent implements OnInit {

  barChartData: any = {
    type: 'line',
    data: {
      datasets: [{
        data: [{x: '2016-12-25', y: 20}, {x: '2016-12-26', y: 10}]
      }]
    }
  }
  barChartOptions: any = {
      type: 'line',
      data: this.barChartData,
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
    const DATA_COUNT = 12;
    const labels = [];
    for (let i = 0; i < DATA_COUNT; ++i) {
      labels.push(i.toString());
    }
    const datapoints = [0, 20, 20, 60, 60, 120, NaN, 180, 120, 125, 105, 110, 170];
    this.barChartData = {
      labels: labels,
      datasets: [
        {
          label: 'Cubic interpolation (monotone)',
          data: datapoints,
          fill: false,
          cubicInterpolationMode: 'monotone',
          tension: 0.4
        }, {
          label: 'Cubic interpolation',
          data: datapoints,
          fill: false,
          tension: 0.4
        }, {
          label: 'Linear interpolation (default)',
          data: datapoints,
          fill: false
        }
      ]
    };
  }
}
