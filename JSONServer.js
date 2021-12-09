var express = require('express');
var app = express();
app.use(express.json);
var fs = require("fs");



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


 app.post('/addFlight', (req, res) => {

   if (!req.body) 
   {
      //Bad request
      res.status(400).send("Null body");
   }
   
   const config = require("./Flights.json");
   const addFlightKey = config.length + 2;
   config.addFlightKey = req.body;
   console.log(req.body);
   res.send(req.body);
   
   
 }) 
 


var server = app.listen(8090, function () {
    var host = server.address().address;
    var port = server.address().port;
    
    console.log("Example app listening at http://%s:%s", host, port)
 })