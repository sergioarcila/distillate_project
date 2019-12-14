import { Component, OnInit } from '@angular/core';
import { APIRequest } from '../../services/api.service';

@Component({
  selector: 'app-distillate',
  templateUrl: './distillate.component.html',
  styleUrls: ['./distillate.component.scss']
})
export class DistillateComponent implements OnInit {
  history = [];
  columns = [
    {
      title: 'PADD I Turnarounds'
    },
    {
      title: 'Runs'
    },
    {
      title: 'Refinery Yield'
    },
    {
      title: 'Production'
    },
    {
      title: 'Imports'
    },
    {
      title: 'Exports',
    },
    {
      title: 'Net Imports'
    },
    {
      title: 'Extra Exports',
    },
    {
      title: 'Other + InterPADD Shipments',
    },
    {
      title: 'Total Supply'
    },
    {
      title: 'PADD I Demand',
    },
    {
      title: 'Real US demand'
    },
    {
      title: 'Reported US Demand',
    },
    {
      title: 'PADD I / US Demand',
    },
    {
      title: 'PADD I HDD',
    },
    {
      title: 'US HDD',
    },
    {
      title: 'PADD I HDD-Norm',
    },
    {
      title: 'US HDD-Norm',
    },
    {
      title: 'PADD I HDD Actual-Norm'
    },
    {
      title: 'US HDD Actual-Norm'
    },
    {
      title: 'Stock Change MBD'
    },
    {
      title: 'Stock Change MB'
    },
    {
      title: 'PADD I Stocks'
    },
    {
      title: 'C. Atl. Stocks'
    },
    {
      title: 'PADD I - C. Atl.'
    },
    {
      title: 'C. Atl. / PADD I',
    },
  ];
  constructor(public api: APIRequest) { }

  ngOnInit() {
    this.api.get('/grid/get_oil.php', {}, response => {
      console.log(response);
      let dat;
      this.history = response.history.map(function (item) {
        dat = item.datum.split('-');
        item.datum = new Date(dat[0], dat[1] - 1, dat[2]);
        item.datum_text = item.datum.toLocaleString(undefined, { year: 'numeric', day: 'numeric', month: 'short' });
        return item;
      }).sort(function (a, b) {
        // sort by date
        return a.datum.getTime() - b.datum.getTime();
      });
      console.log(this.history);
    });
  }

}
