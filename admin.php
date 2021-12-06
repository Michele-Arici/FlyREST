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
                <div class="subheader mb-2">Admin actions</div>
                <a href="#" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modal-report">
                  Add a flight
                </a>
                <a href="#" class="mt-3 btn btn-danger w-100">
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
                <div class="mb-3">
                  <label class="form-label required">Name</label>
                  <input type="text" class="form-control" name="flight_name" placeholder="Flight name">
                </div>
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
                <div class="mb-3">
                  <label class="form-label required">Image link</label>
                  <input type="link" class="form-control" name="flight_image_link" placeholder="Flight name">
                </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-link link-secondary" data-bs-dismiss="modal">
                  Cancel
                </button>
                <button class="btn btn-primary ms-auto" type="submit">
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

  <script>
    var search_result_number = 0;
    function formatDate (input) {
      var datePart = input.match(/\d+/g),
      year = datePart[0], // get only two digits
      month = datePart[1], day = datePart[2];

      return day+'/'+month+'/'+year;
    }
    function PrintFlight(f_name, f_from, f_to, f_departure_date, f_departure_time, f_arrival_date, f_arrival_time, f_image_link) {

        var html = `<div class="col-12 mb-3">
        <div class="card">
          <div class="row row-0">
            <div class="col-3">
              <img src="${f_image_link}" class="w-100 h-100 object-cover">
            </div>
            <div class="col">
              <div class="card-body">
                <h2 class="card-title" style="text-transform: uppercase;">${f_name}</h2>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">From</label>
                      <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plane-departure" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M15 12h5a2 2 0 0 1 0 4h-15l-3 -6h3l2 2h3l-2 -7h3z" transform="rotate(-15 12 12) translate(0 -1)"></path>
                            <line x1="3" y1="21" x2="21" y2="21"></line>
                          </svg>
                        </span>
                        <input type="text" class="form-control" value="${f_from}" readonly="">
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">To</label>
                      <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plane-arrival" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M15 12h5a2 2 0 0 1 0 4h-15l-3 -6h3l2 2h3l-2 -7h3z" transform="rotate(15 12 12) translate(0 -1)"></path>
                            <line x1="3" y1="21" x2="21" y2="21"></line>
                          </svg>
                        </span>
                        <input type="text" class="form-control" value="${f_to}" readonly="">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-8">
                    <div class="mb-3">
                      <label class="form-label">Departure date</label>
                      <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                          <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-event" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <rect x="4" y="5" width="16" height="16" rx="2"></rect>
                            <line x1="16" y1="3" x2="16" y2="7"></line>
                            <line x1="8" y1="3" x2="8" y2="7"></line>
                            <line x1="4" y1="11" x2="20" y2="11"></line>
                            <rect x="8" y="15" width="2" height="2"></rect>
                          </svg>
                        </span>
                        <input type="text" class="form-control" value="${formatDate(f_departure_date)}" readonly="">
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Departure time</label>
                      <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <circle cx="12" cy="12" r="9"></circle>
                            <polyline points="12 7 12 12 15 15"></polyline>
                          </svg>
                        </span>
                        <input type="time" class="form-control" value="${f_departure_time}" readonly="">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-8">
                    <div class="mb-3">
                      <label class="form-label">Arrival date</label>
                      <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                          <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-event" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <rect x="4" y="5" width="16" height="16" rx="2"></rect>
                            <line x1="16" y1="3" x2="16" y2="7"></line>
                            <line x1="8" y1="3" x2="8" y2="7"></line>
                            <line x1="4" y1="11" x2="20" y2="11"></line>
                            <rect x="8" y="15" width="2" height="2"></rect>
                          </svg>
                        </span>
                        <input type="text" class="form-control" value="${formatDate(f_arrival_date)}" readonly="">
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Arrival time</label>
                      <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <circle cx="12" cy="12" r="9"></circle>
                            <polyline points="12 7 12 12 15 15"></polyline>
                          </svg>
                        </span>
                        <input type="time" class="form-control" value="${f_arrival_time}" readonly="">
                      </div>
                    </div>
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
      $f_name = $flight_n;
      $f_from = $flight_a["flight_from"];
      $f_to = $flight_a["flight_to"];
      $f_departure_date = $flight_a["flight_departure_date"];
      $f_departure_time = $flight_a["flight_departure_time"];
      $f_arrival_date = $flight_a["flight_arrival_date"];
      $f_arrival_time = $flight_a["flight_arrival_time"];
      $f_image_link = $flight_a["flight_image_link"];

      echo "<script>PrintFlight('".$f_name."','".$f_from."','".$f_to."','".$f_departure_date."','".$f_departure_time."','".$f_arrival_date."','".$f_arrival_time."','".$f_image_link."')</script>";
    }

    

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $flight_name = $_POST["flight_name"];
      $flight_from = $_POST["flight_from"];
      $flight_to = $_POST["flight_to"];
      $flight_departure_date = $_POST["flight_departure_date"];
      $flight_departure_time = $_POST["flight_departure_time"];
      $flight_arrival_date = $_POST["flight_arrival_date"];
      $flight_arrival_time = $_POST["flight_arrival_time"];
      $flight_first_class = $_POST["flight_first_class"];
      $flight_second_class = $_POST["flight_second_class"];
      $flight_economy_class = $_POST["flight_economy_class"];
      $flight_image_link = $_POST["flight_image_link"];

      if (isset($flight_name) && isset($flight_from) && isset($flight_to) && isset($flight_departure_date) && isset($flight_departure_time) && isset($flight_arrival_date) && isset($flight_arrival_time) && isset($flight_first_class) && isset($flight_second_class) && isset($flight_economy_class) && isset($flight_image_link)) {
        $string = file_get_contents("Flights.json");
        if ($string === false) {
            // deal with error...
        }

        $json_a = json_decode($string, true);
        if ($json_a === null) {
            // deal with error...
        }

        foreach ($json_a as $flight_n => $flight_a) {
          $new_id = $flight_a['flight_id']+1;
          echo "nuovo id: " . $new_id . "</br>";
        }

        $array = array($flight_name => array("flight_id" => $new_id, "flight_from" => $flight_from, "flight_to" => $flight_to, "flight_departure_date" => $flight_departure_date, "flight_departure_time" => $flight_departure_time, "flight_arrival_date" => $flight_arrival_date, "flight_arrival_time" => $flight_arrival_time, "flight_first_class" => $flight_first_class, "flight_second_class" => $flight_second_class, "flight_economy_class" => $flight_economy_class, "flight_image_link" => $flight_image_link));
        $json_a += $array;
        $json_a = json_encode($json_a);
        file_put_contents("Flights.json", $json_a);
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