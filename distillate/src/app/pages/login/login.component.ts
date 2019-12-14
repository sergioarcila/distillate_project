import { Component, OnInit } from '@angular/core';
import { APIRequest } from '../../services/api.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {
  username = '';
  password = '';
  constructor(public api: APIRequest) { }

  ngOnInit() {
  }
  login() {
    this.api.post('/login.php', {
      username: this.username,
      password: this.password
    }, response => {
      console.log(response);
    });
  }
}
