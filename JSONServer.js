var express = require('express');
var app = express();
var fs = require("fs");



var Flight = {
   "Fly4" : {
      "id" : "maesh",
      "company" : "password1",
      "date" : "teacher",
      "from": 1,
      "to": 2,
      "price": 2,
      "departT": 2,
      "arrivalT": 2
   }
}

app.get('/listFlights', function (req, res) {
    fs.readFile( __dirname + "/" + "Flights.json", 'utf8', function (err, data) {
       console.log( data );
       res.end( data );
    });
 })

 app.post('/addFlight', function (req, res) {
   console.log("Got a POST request for the homepage");
   res.send('Hello POST');
})

var server = app.listen(8090, function () {
    var host = server.address().address;
    var port = server.address().port;
    
    console.log("Example app listening at http://%s:%s", host, port)
 })