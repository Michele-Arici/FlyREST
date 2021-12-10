var express = require('express');
var app = express();
const cors = require('cors');
app.use(express.json());
var fs = require("fs");
const { stringify } = require('querystring');

app.use(cors({
  origin: "*",

}));


 app.get('/getFlight/:flight_from/:flight_to/:flight_departure_date', (req, res) => {
   let responseArray = [];
   const config = require("./Flights.json");
   console.log("yes");
   for (const flight in config)
   {
      if(config[flight]["flight_from"] === req.params.flight_from && config[flight]["flight_to"] === req.params.flight_to && config[flight]["flight_departure_date"] === req.params.flight_departure_date)
         responseArray.push(config[flight]);
   }
   var jsonObjResp = JSON.stringify(responseArray);

   console.log(jsonObjResp);
   res.send(jsonObjResp);

 });


 app.post('/addFlight', (req, res) => {

   if (!req.body) 
   {
      //Bad request
      res.status(400).send("Null body");
   }
   
   let config = require("./Flights.json");
   const addFlightKey = Object.keys(config).length + 1;
   console.log(addFlightKey);
   config[addFlightKey] = req.body;
   config = JSON.stringify(config);
   fs.writeFile("./Flights.json", config, 'utf8', function (err) {
      if (err) {
          console.log("An error occured while writing JSON Object to File.");
          return console.log(err);
      }
      console.log("JSON file has been saved.");
  });


   console.log(req.body);
   res.send(config);
   
   
 });

 app.put('/updateFlight/:id', (req, res) => {
   let config = require("./Flights.json");
   const idUpdate = req.params.id;
   if (!config.hasOwnProperty(idUpdate))
      res.status(404).send("The flight with following id does not exist!");
   else
   {
      config[idUpdate] = req.body;
      config = JSON.stringify(config);
      fs.writeFile("./Flights.json", config, 'utf8', function (err) {
         if (err) {
             console.log("An error occured while writing JSON Object to File.");
             return console.log(err);
         }

         console.log("JSON file has been saved.");
     });
     
     res.send(config);
   }
   
});


app.delete('/deleteFlight/:id', (req, res) => {

   let config = require("./Flights.json");
   const idUpdate = req.params.id;
   if (!config.hasOwnProperty(idUpdate))
      res.status(404).send("The flight with following id does not exist!");
   else
   {
      delete config[idUpdate];
      config = JSON.stringify(config);
         fs.writeFile("./Flights.json", config, 'utf8', function (err) {
            if (err) {
                console.log("An error occured while writing JSON Object to File.");
                return console.log(err);
            }

            console.log("JSON file has been saved.");
        });
        res.send(config);
   }

});
server = app.listen(8090,  function () {
  var host = server.address().address;
  var port = server.address().port;
  
  console.log("Example app listening at http://%s:%s", host, port);
});


