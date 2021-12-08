<?php
    $starttime = microtime(true);
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
      $get_flight_from = $_GET["flight_from"];
      $get_flight_class = $_GET["flight_class"];
      $get_flight_departure = $_GET["flight_depart"];
      $get_flight_arrival = $_GET["flight_arrival"];
      $get_flight_adults = $_GET["flight_adults"];
      $get_flight_childs = $_GET["flight_childs"];
    }
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Results</title>

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
            <form action="" method="get">
                  <div class="subheader mb-2">Category</div>
                  <div class="list-group list-group-transparent mb-3">
                    <a class="list-group-item list-group-item-action d-flex align-items-center active" href="#">
                      Games
                      <small class="text-muted ms-auto">24</small>
                    </a>
                    <a class="list-group-item list-group-item-action d-flex align-items-center" href="#">
                      Clothing
                      <small class="text-muted ms-auto">149</small>
                    </a>
                    <a class="list-group-item list-group-item-action d-flex align-items-center" href="#">
                      Jewelery
                      <small class="text-muted ms-auto">88</small>
                    </a>
                    <a class="list-group-item list-group-item-action d-flex align-items-center" href="#">
                      Toys
                      <small class="text-muted ms-auto">54</small>
                    </a>
                  </div>
                  <div class="subheader mb-2">Rating</div>
                  <div class="mb-3">
                    <label class="form-check mb-1">
                      <input type="radio" class="form-check-input" name="form-stars" value="5 stars" checked="">
                      <span class="form-check-label">5 stars</span>
                    </label>
                    <label class="form-check mb-1">
                      <input type="radio" class="form-check-input" name="form-stars" value="4 stars">
                      <span class="form-check-label">4 stars</span>
                    </label>
                    <label class="form-check mb-1">
                      <input type="radio" class="form-check-input" name="form-stars" value="3 stars">
                      <span class="form-check-label">3 stars</span>
                    </label>
                    <label class="form-check mb-1">
                      <input type="radio" class="form-check-input" name="form-stars" value="2 and less stars">
                      <span class="form-check-label">2 and less stars</span>
                    </label>
                  </div>
                  <div class="subheader mb-2">Tags</div>
                  <div class="mb-3">
                    <label class="form-check mb-1">
                      <input type="checkbox" class="form-check-input" name="form-tags[]" value="business" checked="">
                      <span class="form-check-label">business</span>
                    </label>
                    <label class="form-check mb-1">
                      <input type="checkbox" class="form-check-input" name="form-tags[]" value="evening">
                      <span class="form-check-label">evening</span>
                    </label>
                    <label class="form-check mb-1">
                      <input type="checkbox" class="form-check-input" name="form-tags[]" value="leisure">
                      <span class="form-check-label">leisure</span>
                    </label>
                    <label class="form-check mb-1">
                      <input type="checkbox" class="form-check-input" name="form-tags[]" value="party">
                      <span class="form-check-label">party</span>
                    </label>
                  </div>
                  <div class="subheader mb-2">Price</div>
                  <div class="row g-2 align-items-center mb-3">
                    <div class="col">
                      <div class="input-group">
                        <span class="input-group-text">
                          $
                        </span>
                        <input type="text" class="form-control" placeholder="from" value="3" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-auto">—</div>
                    <div class="col">
                      <div class="input-group">
                        <span class="input-group-text">
                          $
                        </span>
                        <input type="text" class="form-control" placeholder="to" autocomplete="off">
                      </div>
                    </div>
                  </div>
                  <div class="subheader mb-2">Shipping</div>
                  <div>
                    <select name="" class="form-select">
                      <option>United Kingdom</option>
                      <option>USA</option>
                      <option>Germany</option>
                      <option>Poland</option>
                      <option>Other…</option>
                    </select>
                  </div>
                  <div class="mt-5">
                    <button class="btn btn-primary w-100">
                      Confirm changes
                    </button>
                    <a href="#" class="btn btn-link w-100">
                      Reset to defaults
                    </a>
                  </div>
                </form>
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
      $f_id = $flight_a["flight_id"];
      $f_from = $flight_a["flight_from"];
      $f_to = $flight_a["flight_to"];
      $f_departure_date = $flight_a["flight_departure_date"];
      $f_departure_time = $flight_a["flight_departure_time"];
      $f_arrival_date = $flight_a["flight_arrival_date"];
      $f_arrival_time = $flight_a["flight_arrival_time"];
      $f_image_link = $flight_a["flight_image_link"];

      if ($f_from == $get_flight_departure && $f_to == $get_flight_arrival) {
        echo "<script>PrintFlight('".$f_name."','".$f_from."','".$f_to."','".$f_departure_date."','".$f_departure_time."','".$f_arrival_date."','".$f_arrival_time."','".$f_image_link."')</script>";
      }

    }

  ?>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      var load_time = "<?php echo $loading_page_time; ?>";
      document.getElementById('page_loading_time_results').innerHTML = 'Found '+search_result_number+' results ('+Math.round(load_time * 1000) / 1000+' seconds)';
    });
  </script>
</body>

</html>