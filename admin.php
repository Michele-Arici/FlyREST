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
  <title>FlyREST</title>

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
              <div class="modal-footer">
                <button class="btn btn-link link-secondary" data-bs-dismiss="modal">
                  Cancel
                </button>
                <button class="btn btn-primary ms-auto" type="submit">
                  <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
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
    function PrintFlight(json) {
      for (let i = 0; i < json.length; i++) {
        const element = json[i];
        console.log(element);
        var html = `<div class="col-12">
          <div class="card">
            <div class="row row-0">
              <div class="col-3">
                <img src="https://www.w3schools.com/images/lamp.jpg" class="w-100 h-100 object-cover"
                  alt="Card side image">
              </div>
              <div class="col">
                <div class="card-body">
                  <h3 class="card-title">Volo #2</h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam deleniti fugit incidunt,
                    iste, itaque minima
                    neque pariatur perferendis sed suscipit velit vitae voluptatem.</p>
                </div>
              </div>
            </div>
          </div>
        </div>`

        
      }
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

    $
    echo "<script>PrintFlight(".$json_a.")</script>";

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
        
      if (isset($flight_name) && isset($flight_from) && isset($flight_to) && isset($flight_departure_date) && isset($flight_departure_time) && isset($flight_arrival_date) && isset($flight_arrival_time) && isset($flight_first_class) && isset($flight_second_class) && isset($flight_economy_class)) {
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

        $array = array($flight_name => array("flight_id" => $new_id, "flight_from" => $flight_from, "flight_to" => $flight_to, "flight_departure_date" => $flight_departure_date, "flight_departure_time" => $flight_departure_time, "flight_arrival_date" => $flight_arrival_date, "flight_arrival_time" => $flight_arrival_time, "flight_first_class" => $flight_first_class, "flight_second_class" => $flight_second_class, "flight_economy_class" => $flight_economy_class));
        $json_a += $array;
        $json_a = json_encode($json_a);
        file_put_contents("Flights.json", $json_a);
      }
    }
  ?>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      var load_time = "<?php echo $loading_page_time; ?>";
      document.getElementById('page_loading_time_results').innerHTML = 'About XXX results ('+Math.round(load_time * 100) / 100+' seconds)';
    });
  </script>
</body>

</html>