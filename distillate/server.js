// server.js
var path = require('path');
const express = require('express');
var proxyTable = require('./proxy-api');
var proxyMiddleware = require('http-proxy-middleware');
const app = express();
// Run the app by serving the static files
// in the dist directory
Object.keys(proxyTable).forEach(function (context) {
    var options = proxyTable[context]
    if (typeof options === 'string') {
        options = { target: options }
    }
    console.log(options);
    app.use(proxyMiddleware(options.filter || context, options))
})
app.use(express.static(__dirname + '/dist'));
// Start the app by listening on the default
// Heroku port
app.listen(process.env.PORT || 8080);

app.get('/*', function (req, res) {
    res.sendFile(path.join(__dirname + '/dist/index.html'));
});