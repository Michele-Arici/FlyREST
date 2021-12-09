var express = require('express');
var app = express();
var fs = require("fs");





app.get('/listFlights', function (req, res) {
    fs.readFile( __dirname + "/" + "Flights.json", 'utf8', function (err, data) {
       console.log( data );
       res.send( data );
    });
 })



 app.get('/getFlight/:flight_from/:flight_to/:flight_departure_date', (req, res) => {
   let responseArray = [];
   const config = require("./Flights.json");
   for (const flight in config)
   {
      if(config[flight]["flight_from"] === req.params.flight_from && config[flight]["flight_to"] === req.params.flight_to && config[flight]["flight_departure_date"] === req.params.flight_departure_date)
         responseArray.push(config[flight]);
   }
   var jsonObjResp = JSON.stringify(responseArray);
   res.send(jsonObjResp);

 }) 

 


var server = app.listen(8090, function () {
    var host = server.address().address;
    var port = server.address().port;
    
    console.log("Example app listening at http://%s:%s", host, port)
 })