import { Injectable } from '@angular/core';
import { Http, RequestOptions, Request, RequestMethod, Headers } from '@angular/http';
import { ServerUrl } from './configs';
import 'rxjs/add/operator/timeout';

@Injectable()
export class APIRequest {
    constructor(public http: Http) {

    }
    call(method = '', params = {}, callback?, timeouts = 0) {
        const headers = new Headers();
        headers.append('Content-Type', 'application/x-www-form-urlencoded');

        const options = new RequestOptions({
            method: RequestMethod.Post,
            url: `${ServerUrl}/${method}`,
            headers,
            withCredentials: true,
            body: params
        });

        this.http.request(new Request(options))
            .timeout(10000)
            .subscribe(response => {
                let res = null;
                try {
                    res = response.json();
                } catch (error) {
                    alert('The server response contains invalid JSON. Could not process it.');
                }
                if (callback) {
                    callback(res);
                }
            }, err => {
                if (callback) {
                    callback(err);
                }
            });
    }
    get(method = '', params = {}, callback?) {
        const headers = new Headers();
        headers.append('Content-Type', 'application/x-www-form-urlencoded');

        const paramsList = [];
        for (const key of Object.keys(params)) {
            paramsList.push(`${key}=${params[key]}`);
        }
        const encodedParams = paramsList.join('&');

        const options = new RequestOptions({
            method: RequestMethod.Get,
            url: ServerUrl + method + ((/\?/).test(method) ? '&' : '?') + (new Date()).getTime(),
            headers,
            withCredentials: true,
            body: encodedParams
        });

        this.http.request(new Request(options))
            .timeout(10000)
            .subscribe(response => {
                let res = null;
                try {
                    res = response.json();
                } catch (error) {
                    alert('The server response contains invalid JSON. Could not process it.');
                }
                if (callback) {
                    callback(res);
                }
            }, err => {
                if (callback) {
                    callback(err);
                }
            });
    }
    post(method = '', params = {}, callback?) {
        const headers = new Headers();
        headers.append('Content-Type', 'application/x-www-form-urlencoded');

        const options = new RequestOptions({
            method: RequestMethod.Post,
            url: ServerUrl + method + ((/\?/).test(method) ? '&' : '?') + (new Date()).getTime(),
            headers,
            withCredentials: true,
            body: params
        });

        this.http.request(new Request(options))
            .timeout(10000)
            .subscribe(response => {
                let res = null;
                try {
                    res = response.json();
                } catch (error) {
                    alert('The server response contains invalid JSON. Could not process it.');
                }
                if (callback) {
                    callback(res);
                }
            }, err => {
                if (callback) {
                    callback(err);
                }
            });
    }
}
