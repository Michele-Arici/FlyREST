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
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label required">From</label>
                      <input class="form-control" list="datalistOptions" name="flight_from" placeholder="Type to search...">
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
                      <input class="form-control" list="datalistOptions" name="flight_to" placeholder="Type to search...">
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
                      <input type="date" name="flight_departure_date" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label required">Departure time</label>
                      <input type="time" name="flight_departure_time" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-8">
                    <div class="mb-3">
                      <label class="form-label required">Arrival date</label>
                      <input type="date" name="flight_arrival_date" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label required">Arrival time</label>
                      <input type="time" name="flight_arrival_time" class="form-control">
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label required">First class ticket cost</label>
                      <input type="number" class="form-control" name="flight_first_class" placeholder="Cost">
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label required">Second class ticket cost</label>
                      <input type="number" class="form-control" name="flight_second_class" placeholder="Cost">
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label required">Economy class ticket cost</label>
                      <input type="number" class="form-control" name="flight_economy_class" placeholder="Cost">
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-3">
                      <div class="mb-3">
                        <label class="form-label required">Stages</label>
                        <input type="number" class="form-control" name="flight_stages" placeholder="Stages">
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
                      <input type="number" class="form-control" name="flight_seats" placeholder="Seats">
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
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete flights</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post" autocomplete="off">
          <div class="modal-body">
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
                <div class="h1 m-0">€${f_first} €${f_second} €${f_economy} </div>
                <div class="text-muted small mb-3">FIRST | SECOND | ECONOMY</div>
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
        <input type="checkbox" name="form-flights-selected[]" value="${f_id}" class="form-selectgroup-input">
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
  </script>
  <?php
    $endtime = microtime(true);
    $loading_page_time = $endtime - $starttime;

    $string = file_get_contents("Flights.json");
    if ($string === false) {
        // deal with error...
    }

    $json_a = json_decode($string, true);
    if ($json_a === null) {
        // deal with error...
    }

    foreach ($json_a as $flight_n => $flight_a) {
      $f_id = $flight_n;
      $f_from = $flight_a["flight_from"];
      $f_to = $flight_a["flight_to"];
      $f_departure_date = $flight_a["flight_departure_date"];
      $f_departure_time = $flight_a["flight_departure_time"];
      $f_arrival_date = $flight_a["flight_arrival_date"];
      $f_arrival_time = $flight_a["flight_arrival_time"];
      $f_first_class = $flight_a["flight_first_class"];
      $f_second_class = $flight_a["flight_second_class"];
      $f_economy_class = $flight_a["flight_economy_class"];
      $f_company = $flight_a["flight_company"];
      $f_stages = $flight_a["flight_stages"];

      echo "<script>PrintFlight('".$f_from."','".$f_to."','".$f_departure_date."','".$f_departure_time."','".$f_arrival_date."','".$f_arrival_time."','".$f_company."','".$f_stages."','".$f_first_class."','".$f_second_class."','".$f_economy_class."')</script>";
      echo "<script>PrintFlightRemoveForm('".$f_id."','".$f_from."','".$f_to."','".$f_departure_date."','".$f_company."','".$f_departure_time."')</script>";
    }
    

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (isset($_POST['remove_flights_button'])) {
        $selected_flights = $_POST['form-flights-selected'];

        $string_json = file_get_contents("Flights.json");
        if ($string_json === false) {
            // deal with error...
        }
        $json_array = json_decode($string_json, true);

        foreach ($json_a as $flight_n => $flight_a) {
          foreach ($selected_flights as $key => $value) {
            if ($flight_n == $value) {
              unset($json_array[$flight_n]);
            }
          }
        }

        $json_array = json_encode($json_array);
        file_put_contents("Flights.json", $json_array);
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
  
        if (isset($flight_from) && isset($flight_to) && isset($flight_departure_date) && isset($flight_departure_time) && isset($flight_arrival_date) && isset($flight_arrival_time) && isset($flight_first_class) && isset($flight_second_class) && isset($flight_economy_class) && isset($flight_company) && isset($flight_stages) && isset($flight_seats)) {
          $string = file_get_contents("Flights.json");
          if($flight_departure_date>$flight_arrival_date){
            echo "<h5 class='notification text-danger mt-3'>The departure date must come before the arrival date</h5>";
          }else if($flight_departure_date==$flight_arrival_date){
            if($flight_departure_time>$flight_arrival_time)
              echo "<h5 class='notification text-danger mt-3'>The departure time must come before the arrival time</h5>";
          }
          if ($string === false) {
              // deal with error...
          }
  
          $json_a = json_decode($string, true);
          if ($json_a === null) {
              // deal with error...
          }
  
          foreach ($json_a as $flight_n => $flight_a) {
            $new_id = $flight_n+1;
            echo "nuovo id: " . $new_id . "</br>";
          }
  
          $array = array($new_id => array("flight_from" => $flight_from, "flight_to" => $flight_to, "flight_departure_date" => $flight_departure_date, "flight_departure_time" => $flight_departure_time, "flight_arrival_date" => $flight_arrival_date, "flight_arrival_time" => $flight_arrival_time, "flight_first_class" => $flight_first_class, "flight_second_class" => $flight_second_class, "flight_economy_class" => $flight_economy_class, "flight_stages" => $flight_stages, "flight_company" => $flight_company, "flight_seats" => $flight_seats));
          $json_a += $array;
          $json_a = json_encode($json_a);
          file_put_contents("Flights.json", $json_a);
          echo "<meta http-equiv='refresh' content='0'>";
        }
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