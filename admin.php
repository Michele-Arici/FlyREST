<?php
  $starttime = microtime(true);
  session_start();
  if ($_SESSION['username'] != "admin") {
    header('Location: '. 'not_autorized.php');
  }


  $csv = array_map('str_getcsv', file('airports.csv'));
  array_walk($csv, function(&$a) use ($csv) {
    $a = array_combine($csv[0], $a);
  });
  array_shift($csv); # remove column header
  //print_r($csv);
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Admin</title>

  <script src="https://unpkg.com/@tabler/core@1.0.0-beta4/dist/js/tabler.min.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/@tabler/core@1.0.0-beta4/dist/css/tabler.min.css">
</head>

<body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  var company_logo = {"ryanair": "https://q-xx.bstatic.com/data/airlines_logo/square_96/FR.png", "wizz_air": "https://q-xx.bstatic.com/data/airlines_logo/square_96/W6.png", "ita_airlines": "https://q-xx.bstatic.com/data/airlines_logo/square_96/AZ.png", "easyjet": "https://q-xx.bstatic.com/data/airlines_logo/square_96/U2.png", "air_france": "https://q-xx.bstatic.com/data/airlines_logo/square_96/AF.png", "lufthansa": "https://q-xx.bstatic.com/data/airlines_logo/square_96/LH.png", "swiss": "https://q-xx.bstatic.com/data/airlines_logo/square_96/LX.png", "vueling": "https://q-xx.bstatic.com/data/airlines_logo/square_96/VY.png"};
  var search_result_number = 0;
  function formatDate (input) {
    var datePart = input.match(/\d+/g),
    year = datePart[0], // get only two digits
    month = datePart[1], day = datePart[2];

    return day+'/'+month+'/'+year;
  }

  function PrintFlight(f_from, f_to, f_departure_date, f_departure_time, f_arrival_date, f_arrival_time, f_company, f_stages, f_first, f_second, f_economy) {
    var departure_time = f_departure_time.split(':');
    var depart_date_split = f_departure_date.match(/\d+/g);
    var depart_date = new Date(depart_date_split[0], depart_date_split[1], depart_date_split[2], departure_time[0], departure_time[1]);

    var arrival_time = f_arrival_time.split(':');
    var arrival_date_split = f_arrival_date.match(/\d+/g);
    var arrival_date = new Date(arrival_date_split[0], arrival_date_split[1], arrival_date_split[2], arrival_time[0], arrival_time[1]);

    var diff = Math.abs(arrival_date - depart_date);
    var diff_minutes = Math.floor((diff/1000)/60);

    var hours = Math.floor(diff_minutes / 60);          
    var minutes = diff_minutes % 60;
      
    if (f_stages == "0") {
      f_stages = "Direct";
    } else {
      f_stages = f_stages + " stage";
    }

    var html = `<div class="col-12 mb-3">
      <div class="card">
        <div class="row row-0">
          <div class="col-3 order-md-last text-center" style="border-left: 1px solid rgba(98,105,118,.16);">
            <div class="card-body">
              <div class="h4 m-0">FROM: ${f_from} <br> TO: ${f_to}</div>
              <div class="text-muted small mb-3">€${f_first} FIRST | €${f_second} SECOND | €${f_economy} ECONOMY</div>
            </div>
          </div>
          <div class="col" style="display: flex; align-items:center;">
            <div class="card-body">
              <div class="row">
                <div class="col-2" style="background: url(${company_logo[f_company]}) no-repeat center; background-size: contain;"></div>
                <div class="col-3 text-center">
                  <div class="h1 m-0">${f_departure_time}</div>
                  <div class="text-muted">${formatDate(f_departure_date)}</div>
                </div>
                <div class="col-4 text-center">
                  <div class="h1 m-0">${hours} h ${minutes} min</div>
                  <hr style="margin-top: 4px; margin-bottom: 4px">
                  <div class="text-muted">${f_stages}</div>
                </div>
                <div class="col-3 text-center">
                  <div class="h1 m-0">${f_arrival_time}</div>
                  <div class="text-muted">${formatDate(f_arrival_date)}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>`
    document.getElementById('flight_list').innerHTML += html;
    search_result_number++;
  }

  function PrintFlightRemoveForm(f_id, f_from, f_to, f_departure_date, f_company, f_dep_time) {
    var content = `<label class="form-selectgroup-item flex-fill">
      <input type="radio" name="form-flights-selected[]" value="${f_id}" class="form-selectgroup-input">
      <div class="form-selectgroup-label d-flex align-items-center p-3">
        <div class="me-3">
          <span class="form-selectgroup-check"></span>
        </div>
        <div class="form-selectgroup-label-content d-flex align-items-center">
          <span class="avatar me-3" style="background-image: url(${company_logo[f_company]})"></span>
          <div>
            <div class="font-weight-medium">ID: ${f_id}</div>
            <div class="text-muted">${f_from} | ${f_to} </div>
            <div class="text-muted">${f_departure_date} | ${f_dep_time} </div>
          </div>
        </div>
      </div>
    </label>`
    document.getElementById('remove_flights_list').innerHTML += content;
  }


  function PrintFlightUpdateForm(f_id, f_from, f_to, f_departure_date, f_company, f_dep_time) {
    var content = `<label class="form-selectgroup-item flex-fill">
      <input type="radio" name="form-flights-selected-modify[]" value="${f_id}" class="form-selectgroup-input">
      <div class="form-selectgroup-label d-flex align-items-center p-3">
        <div class="me-3">
          <span class="form-selectgroup-check"></span>
        </div>
        <div class="form-selectgroup-label-content d-flex align-items-center">
          <span class="avatar me-3" style="background-image: url(${company_logo[f_company]})"></span>
          <div>
            <div class="font-weight-medium">ID: ${f_id}</div>
            <div class="text-muted">${f_from} | ${f_to} </div>
            <div class="text-muted">${f_departure_date} | ${f_dep_time} </div>
          </div>
        </div>
      </div>
    </label>`
    document.getElementById('modify_flights_list').innerHTML += content;
  }

  async function getDataById(ID){
    let api_url = "http://localhost:8090/getFlightById/" + encodeURI(ID); 
    const response = await fetch(api_url);
    const data = await response.json();
    console.log(data);
    for (const flights in data)
    {

      let flight_from = data[flights]["flight_from"];
      let flight_to = data[flights]["flight_to"];
      let flight_departure_date = data[flights]["flight_departure_date"];
      let flight_departure_time = data[flights]["flight_departure_time"]; 
      let flight_arrival_date = data[flights]["flight_arrival_date"];
      let flight_arrival_time = data[flights]["flight_arrival_time"]; 
      let flight_first_class = data[flights][ "flight_first_class"];
      let flight_second_class = data[flights]["flight_second_class"];
      let flight_economy_class = data[flights]["flight_economy_class"];
      let flight_stages = data[flights]["flight_stages"];
      let flight_company = data[flights]["flight_company"];
      let flight_seats = data[flights]["flight_seats"];

      return [flight_from,flight_to,flight_departure_date,flight_departure_time,flight_arrival_date,flight_arrival_time,flight_first_class,flight_second_class,flight_economy_class,flight_stages,flight_company,flight_seats];

    }

  }
</script>
<script>


async function deleteMethod(idToDelete) {
    url = "http://localhost:8090/deleteFlight/"  + encodeURI(idToDelete);
    // Awaiting fetch which contains 
    // method, headers and content-type
    const response = await fetch(url, {
        method: 'DELETE',
        headers: {
            'Content-type': 'application/json'
        }
    });

    // Awaiting for the resource to be deleted
    const resData = 'resource deleted...';

    
    //document.location.reload(true);
}

async function deleteUpdateIdMethod() {
    url = "http://localhost:8090/deleteUpdateFlight" ;
    // Awaiting fetch which contains 
    // method, headers and content-type
    const response = await fetch(url, {
        method: 'DELETE',
        headers: {
            'Content-type': 'application/json'
        }
    });

    // Awaiting for the resource to be deleted
    const resData = 'resource deleted...';
    //document.location.reload(true);
}
</script>

<script>
  function ReturnModifyModal() {
    var div = `<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document"  style="overflow-y: initial !important; ">
  <!--<div class="modal-dialog" style="overflow-y: scroll; max-height:85%;  margin-top: 50px; margin-bottom:50px;" >-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modify flight</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" id="modify_closed" aria-label="Close"></button>
      </div>

        <div class="modal-body" style="height: 80vh; overflow-y: auto;" id="modify_modal_body">
          <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column" id="modify_flights_list">
              
          </div>
        </div>
        <div class="modal-footer" id="modify_footer">
          <button class="btn btn-warning ms-auto" onclick="AddNewContentModify()" name="modify_flights_button">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"></path>
              <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"></path>
              <line x1="16" y1="5" x2="19" y2="8"></line>
            </svg>
            Modify
          </button>
        </div>

    </div>
  </div>`;
    document.getElementById('modal-large1').innerHTML = div;
    getAllDataOnlyUpdate();
  }
    function AddNewContentModify() {
      var selected_id = 0;
      var checkboxes = document.querySelectorAll('input[type=radio]:checked')

      for (var i = 0; i < checkboxes.length; i++) {
        selected_id = checkboxes[i].value;
      }

      (async () => {
        var id_values = await getDataById(selected_id);
        var element = `<form method="POST" autocomplete="off">
        <div class="modal-body">
            <div class="row">
              <div class="col-12" id="error_add_flight">
                
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label required">From</label>
                  <input class="form-control" list="datalistOptions" name="flight_from" placeholder="Type to search..." value="${id_values[0]}" required>
                  <datalist id="datalistOptions">
                    
                  </datalist>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label required">To</label>
                  <input class="form-control" list="datalistOptions" name="flight_to" placeholder="Type to search..." value="${id_values[1]}" required>
                  <datalist id="datalistOptions">
  
                  </datalist>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-8">
                <div class="mb-3">
                  <label class="form-label required">Departure date</label>
                  <input type="date" name="flight_departure_date" class="form-control" value="${id_values[2]}" required>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label required">Departure time</label>
                  <input type="time" name="flight_departure_time" class="form-control" value="${id_values[3]}" required>
                </div>
              </div>
              <div class="col-lg-8">
                <div class="mb-3">
                  <label class="form-label required">Arrival date</label>
                  <input type="date" name="flight_arrival_date" class="form-control" value="${id_values[4]}" required>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label required">Arrival time</label>
                  <input type="time" name="flight_arrival_time" class="form-control" value="${id_values[5]}" required>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label required">First class ticket cost</label>
                  <input type="number" class="form-control" name="flight_first_class" value="${id_values[6]}" placeholder="Cost" required>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label required">Second class ticket cost</label>
                  <input type="number" class="form-control" name="flight_second_class" value="${id_values[7]}" placeholder="Cost" required>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label required">Economy class ticket cost</label>
                  <input type="number" class="form-control" name="flight_economy_class" min="" placeholder="Cost" value="${id_values[8]}" required>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-3">
                  <div class="mb-3">
                    <label class="form-label required">Stages</label>
                    <input type="number" class="form-control" name="flight_stages" placeholder="Stages" value="${id_values[9]}" required>
                  </div>
              </div>
              <div class="col-6">
                <div class="mb-3">
                  <label class="form-label required">Company</label>
                  <select class="form-select" name="flight_company" value="${id_values[10]}">
                    <option value="ryanair">Ryanair</option>
                    <option value="ita_airways">ITA Airways</option>
                    <option value="lufthansa">Lufthansa</option>
                    <option value="easyjet">Easyjet</option>
                    <option value="wizz_air">Wizz Air</option>
                    <option value="swiss">Swiss</option>
                    <option value="vueling">Vueling</option>
                    <option value="air_france">Air France</option>
                  </select>
                </div>
              </div>
              <div class="col-3">
                <div class="mb-3">
                  <label class="form-label required">Total seats</label>
                  <input type="number" class="form-control" name="flight_seats" placeholder="Seats" min="1" value="${id_values[11]}" required>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <input type="number" class="form-control" name="flight_id" value="${selected_id}" hidden>
            <button class="btn btn-warning ms-auto" name="modify_flight_button_n" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"></path>
                <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"></path>
                <line x1="16" y1="5" x2="19" y2="8"></line>
              </svg>
              Modify flight
            </button>
          </div> </form>`
        document.getElementById('modify_modal_body').innerHTML = element;
        document.getElementById('modify_modal_body').style.height = null;
        document.getElementById('modify_footer').innerHTML = '';
        document.getElementById('modify_closed').addEventListener("click", function(e) {
          ReturnModifyModal();
        }, false);        
      })()

    }
  </script>
    <header class="navbar navbar-expand-md navbar-light d-print-none">
    <div class="container-xl">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
        <a href=".">
          <img src="img/logo_piccolo.png" alt="FlyREST" class="navbar-brand-image" width="110" height="32">
        </a>
      </h1>

      <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="main.php">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <polyline points="5 12 3 12 12 3 21 12 19 12"></polyline>
                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path>
                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path>
                  </svg>
                </span>
                <span class="nav-link-title">
                  Home
                </span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="docs/index.php">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                  <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clipboard-list" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path>
                    <rect x="9" y="3" width="6" height="4" rx="2"></rect>
                    <line x1="9" y1="12" x2="9.01" y2="12"></line>
                    <line x1="13" y1="12" x2="15" y2="12"></line>
                    <line x1="9" y1="16" x2="9.01" y2="16"></line>
                    <line x1="13" y1="16" x2="15" y2="16"></line>
                  </svg>
                </span>
                <span class="nav-link-title">
                  Documentation
                </span>
              </a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="admin.php">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                  <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                  </svg>
                </span>
                <span class="nav-link-title">
                  Admin
                </span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </header>
  <div class="wrapper">
    <div class="page-wrapper">
      <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
          <div class="row align-items-center">
            <div class="col">
              <h2 class="page-title">
                Search results
              </h2>
              <div class="text-muted mt-1" id="page_loading_time_results"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="page-body">
        <div class="container-xl">
          <div class="row">
            <div class="col-3">
              <div class="mt-2">
                <div class="subheader mb-4">Admin actions</div>
                <a href="#" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modal-report">
                  Add a flight
                </a>
                <a href="#" class="mt-3 btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#modal-large">
                  Remove a flight
                </a>
                </a>
                <a href="#" class="mt-3 btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#modal-large1">
                  Modify a flight
                </a>
              </div>
            </div>
            <div class="col-9">
              <div class="row" id="flight_list">

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <form method="POST" autocomplete="off">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">New flight</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
                <div class="row">
                  <div class="col-12" id="error_add_flight">
                    
                  </div>
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label required">From</label>
                      <input class="form-control" list="datalistOptions" name="flight_from" placeholder="Type to search..." required>
                      <datalist id="datalistOptions">
                        <?php
                          for ($i = 0; $i < count($csv); $i++) {
                            if ($csv[$i]["type"] == "small_airport" || $csv[$i]["type"] == "medium_airport" || $csv[$i]["type"] == "large_airport") {
                              $value = $csv[$i]["name"] . " (" . $csv[$i]["iso_region"] . ")";
                              echo "<option value='$value'>";    
                            }
                          }
                        ?>
                      </datalist>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label required">To</label>
                      <input class="form-control" list="datalistOptions" name="flight_to" placeholder="Type to search..." required>
                      <datalist id="datalistOptions">
                        <?php
                          for ($i = 0; $i < count($csv); $i++) {
                            if ($csv[$i]["type"] == "small_airport" || $csv[$i]["type"] == "medium_airport" || $csv[$i]["type"] == "large_airport") {
                              $value = $csv[$i]["name"] . " (" . $csv[$i]["iso_region"] . ")";
                              echo "<option value='$value'>";    
                            }  
                          }
                        ?>
                      </datalist>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-lg-8">
                    <div class="mb-3">
                      <label class="form-label required">Departure date</label>
                      <input type="date" name="flight_departure_date" class="form-control" required>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label required">Departure time</label>
                      <input type="time" name="flight_departure_time" class="form-control" required>
                    </div>
                  </div>
                  <div class="col-lg-8">
                    <div class="mb-3">
                      <label class="form-label required">Arrival date</label>
                      <input type="date" name="flight_arrival_date" class="form-control" required>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label required">Arrival time</label>
                      <input type="time" name="flight_arrival_time" class="form-control" required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label required">First class ticket cost</label>
                      <input type="number" class="form-control" name="flight_first_class" placeholder="Cost" required>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label required">Second class ticket cost</label>
                      <input type="number" class="form-control" name="flight_second_class" placeholder="Cost" required>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label required">Economy class ticket cost</label>
                      <input type="number" class="form-control" name="flight_economy_class" min="" placeholder="Cost" required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-3">
                      <div class="mb-3">
                        <label class="form-label required">Stages</label>
                        <input type="number" class="form-control" name="flight_stages" placeholder="Stages" required>
                      </div>
                  </div>
                  <div class="col-6">
                    <div class="mb-3">
                      <label class="form-label required">Company</label>
                      <select class="form-select" name="flight_company">
                        <option value="ryanair">Ryanair</option>
                        <option value="ita_airways">ITA Airways</option>
                        <option value="lufthansa">Lufthansa</option>
                        <option value="easyjet">Easyjet</option>
                        <option value="wizz_air">Wizz Air</option>
                        <option value="swiss">Swiss</option>
                        <option value="vueling">Vueling</option>
                        <option value="air_france">Air France</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="mb-3">
                      <label class="form-label required">Total seats</label>
                      <input type="number" class="form-control" name="flight_seats" placeholder="Seats" min="1" required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-link link-secondary" data-bs-dismiss="modal">
                  Cancel
                </button>
                <button class="btn btn-primary ms-auto" name="create_flight_button" type="submit">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                  </svg>
                  Create new flight
                </button>
              </div>
        </div>
      </form>
    </div>
  </div>
  <div class="modal modal-blur fade" id="modal-large" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document"  style="overflow-y: initial !important; ">
    <!--<div class="modal-dialog" style="overflow-y: scroll; max-height:85%;  margin-top: 50px; margin-bottom:50px;" >-->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete flights</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post" autocomplete="off">
          <div class="modal-body" style="height: 80vh; overflow-y: auto;">
            <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column" id="remove_flights_list">
                
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-danger ms-auto" name="remove_flights_button" type="submit">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
              </svg>
              Delete
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <div class="modal modal-blur fade" id="modal-large1" tabindex="-1" role="dialog" aria-modal="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document"  style="overflow-y: initial !important; ">
  <!--<div class="modal-dialog" style="overflow-y: scroll; max-height:85%;  margin-top: 50px; margin-bottom:50px;" >-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modify flight</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" id="modify_closed" aria-label="Close"></button>
      </div>

        <div class="modal-body" style="height: 80vh; overflow-y: auto;" id="modify_modal_body">
          <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column" id="modify_flights_list">
              
          </div>
        </div>
        <div class="modal-footer" id="modify_footer">
          <button class="btn btn-warning ms-auto" onclick="AddNewContentModify()" name="modify_flights_button">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"></path>
              <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"></path>
              <line x1="16" y1="5" x2="19" y2="8"></line>
            </svg>
            Modify
          </button>
        </div>

    </div>
  </div>
</div>

<script>
  async function getAllData(){
    let api_url = "http://localhost:8090/getFlights";
    const response = await fetch(api_url);
    const data = await response.json();
    for (const flights in data)
    {
      let flight_from = data[flights]["flight_from"];
      let flight_to = data[flights]["flight_to"];
      let flight_departure_date = data[flights]["flight_departure_date"];
      let flight_departure_time = data[flights]["flight_departure_time"]; 
      let flight_arrival_date = data[flights]["flight_arrival_date"];
      let flight_arrival_time = data[flights]["flight_arrival_time"]; 
      let flight_first_class = data[flights][ "flight_first_class"];
      let flight_second_class = data[flights]["flight_second_class"];
      let flight_economy_class = data[flights]["flight_economy_class"];
      let flight_stages = data[flights]["flight_stages"];
      let flight_company = data[flights]["flight_company"];
      let flight_seats = data[flights]["flight_seats"];

      let ID = parseInt(flights) + 1;
      PrintFlight(flight_from, flight_to,flight_departure_date,flight_departure_time,flight_arrival_date,flight_arrival_time,flight_company,flight_stages,flight_first_class, flight_second_class, flight_economy_class)
      PrintFlightRemoveForm(ID,flight_from, flight_to,flight_departure_date,flight_company,flight_departure_time);
      PrintFlightUpdateForm(ID,flight_from, flight_to,flight_departure_date,flight_company,flight_departure_time);
    }

  }

  async function getAllDataOnlyUpdate(){
    let api_url = "http://localhost:8090/getFlights";
    const response = await fetch(api_url);
    const data = await response.json();
    for (const flights in data)
    {
      let flight_from = data[flights]["flight_from"];
      let flight_to = data[flights]["flight_to"];
      let flight_departure_date = data[flights]["flight_departure_date"];
      let flight_departure_time = data[flights]["flight_departure_time"]; 
      let flight_arrival_date = data[flights]["flight_arrival_date"];
      let flight_arrival_time = data[flights]["flight_arrival_time"]; 
      let flight_first_class = data[flights][ "flight_first_class"];
      let flight_second_class = data[flights]["flight_second_class"];
      let flight_economy_class = data[flights]["flight_economy_class"];
      let flight_stages = data[flights]["flight_stages"];
      let flight_company = data[flights]["flight_company"];
      let flight_seats = data[flights]["flight_seats"];

      let ID = parseInt(flights) + 1;
      PrintFlightUpdateForm(ID,flight_from, flight_to,flight_departure_date,flight_company,flight_departure_time);
    }

  }

  
  function postMethod(f_from, f_to, f_departure_date, f_departure_time, f_arrival_date, f_arrival_time, f_first_class, f_second_class, f_economy_class,  f_company, f_stages, f_seats) {

  // Sending and receiving data in JSON format using POST method
  //

  var xhr = new XMLHttpRequest();
  var url = "http://localhost:8090/addFlight";
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-Type", "application/json");
  xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
          var json = JSON.parse(xhr.responseText);
      }
  };

  let jsonDataToSend = {
    "flight_from": f_from,
    "flight_to": f_to,
    "flight_departure_date": f_departure_date,
    "flight_departure_time": f_departure_time,
    "flight_arrival_date": f_arrival_date,
    "flight_arrival_time": f_arrival_time,
    "flight_first_class": f_first_class,
    "flight_second_class": f_second_class,
    "flight_economy_class": f_economy_class,
    "flight_stages": f_stages,
    "flight_company": f_company,
    "flight_seats": f_seats
  } 


  var data = JSON.stringify(jsonDataToSend);
  xhr.send(data);


  }



  function putMethod(idToUpdate,f_from, f_to, f_departure_date, f_departure_time, f_arrival_date, f_arrival_time, f_first_class, f_second_class, f_economy_class,  f_company, f_stages, f_seats) {

  let jsonDataToSend = {
    "flight_from": f_from,
    "flight_to": f_to,
    "flight_departure_date": f_departure_date,
    "flight_departure_time": f_departure_time,
    "flight_arrival_date": f_arrival_date,
    "flight_arrival_time": f_arrival_time,
    "flight_first_class": f_first_class,
    "flight_second_class": f_second_class,
    "flight_economy_class": f_economy_class,
    "flight_stages": f_stages,
    "flight_company": f_company,
    "flight_seats": f_seats
  } 

  url = "http://localhost:8090/updateFlight/"  + encodeURI(idToUpdate);//id del volo
  fetch(url,{
      method:'PUT',
      headers:{
      'Content-Type':'application/json'
      },
      body:JSON.stringify(jsonDataToSend)
  });



  }
</script>

  <?php
    $endtime = microtime(true);
    $loading_page_time = $endtime - $starttime;

    echo "<script>getAllData();</script>";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (isset($_POST['remove_flights_button'])) {
        $selected_flights = $_POST['form-flights-selected'];
        
       
        foreach ($selected_flights as $IDtoDelete) {
          echo "<script>deleteMethod('".$IDtoDelete."');</script>";
        }
        echo "<script>deleteUpdateIdMethod();</script>";
        echo "<meta http-equiv='refresh' content='0'>";



      } else if (isset($_POST['create_flight_button'])) {
        $flight_from = $_POST["flight_from"];
        $flight_to = $_POST["flight_to"];
        $flight_departure_date = $_POST["flight_departure_date"];
        $flight_departure_time = $_POST["flight_departure_time"];
        $flight_arrival_date = $_POST["flight_arrival_date"];
        $flight_arrival_time = $_POST["flight_arrival_time"];
        $flight_first_class = $_POST["flight_first_class"];
        $flight_second_class = $_POST["flight_second_class"];
        $flight_economy_class = $_POST["flight_economy_class"];
        $flight_company = $_POST["flight_company"];
        $flight_stages = $_POST["flight_stages"];
        $flight_seats = $_POST["flight_seats"];
  

        echo "<script>postMethod('".$flight_from."','".$flight_to."','".$flight_departure_date."','".$flight_departure_time."','".$flight_arrival_date."','".$flight_arrival_time."','".$flight_first_class."','".$flight_second_class."','".$flight_economy_class."','".$flight_company."','".$flight_stages."','".$flight_seats."');</script>";
        echo "<meta http-equiv='refresh' content='0'>";
      } elseif (isset($_POST['modify_flight_button_n'])) {
        
        $flight_id = $_POST["flight_id"];
        $flight_from = $_POST["flight_from"];
        $flight_to = $_POST["flight_to"];
        $flight_departure_date = $_POST["flight_departure_date"];
        $flight_departure_time = $_POST["flight_departure_time"];
        $flight_arrival_date = $_POST["flight_arrival_date"];
        $flight_arrival_time = $_POST["flight_arrival_time"];
        $flight_first_class = $_POST["flight_first_class"];
        $flight_second_class = $_POST["flight_second_class"];
        $flight_economy_class = $_POST["flight_economy_class"];
        $flight_company = $_POST["flight_company"];
        $flight_stages = $_POST["flight_stages"];
        $flight_seats = $_POST["flight_seats"];

        echo "<script>putMethod('".$flight_id."','".$flight_from."','".$flight_to."','".$flight_departure_date."','".$flight_departure_time."','".$flight_arrival_date."','".$flight_arrival_time."','".$flight_first_class."','".$flight_second_class."','".$flight_economy_class."','".$flight_company."','".$flight_stages."','".$flight_seats."')</script>";
        echo "<meta http-equiv='refresh' content='0'>";
      }
    }
  ?>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      var load_time = "<?php echo $loading_page_time; ?>";
      document.getElementById('page_loading_time_results').innerHTML = 'Found '+search_result_number+' results ('+Math.round(load_time * 100) / 100+' seconds)';
    });
  </script>

</body>



</html>