<script>
  var search_result_number = 0;
  function formatDate (input) {
    var datePart = input.match(/\d+/g),
    year = datePart[0],
    month = datePart[1], day = datePart[2];

    return day+'/'+month+'/'+year;
  }

  function PrintFlight(f_id, f_from, f_to, f_departure_date, f_departure_time, f_arrival_date, f_arrival_time, f_company, f_stages, total_cost, f_seats, total_people) {
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
    
    if (f_seats-total_people < 0) {
      var seats_element = `<a href="#" class="btn btn-outline-danger disabled">Sold out</a>`
    } else {
      var seats_element = `<a href="#" class="btn btn-outline-info">Buy</a>`
    }

    var html = `<div class="col-12 mb-3" id="flight_${f_id}">
      <div class="card">
        <div class="row row-0">
          <div class="col-3 order-md-last text-center" style="border-left: 1px solid rgba(98,105,118,.16);">
            <div class="card-body">
              <div class="h1 m-0">€ ${total_cost}</div>
              <div class="text-muted small mb-3">TOTAL PRICE</div>
              ${seats_element}
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
</script>
<script>
  async function getData(departure, arrival, from, totalPeople, flightClass){
    let api_url = "http://localhost:8090/getFlight/" + encodeURI(departure) + "/" + encodeURI(arrival) + "/" + encodeURI(from); // document = (aeroporti decollo, arrivo, e data di decollo)
    const response = await fetch(api_url);
    const data = await response.json();
    console.log(data);
    for (const flights in data)
    {
      let flight_id = flights;
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

      
      let total_cost = 0;


      switch (flightClass) {
        case 'economy_class':
          total_cost =  totalPeople * flight_economy_class ; 
          break;
        case 'second_class':
          total_cost =  totalPeople * flight_second_class; 
          break;
        case 'first_class':
          total_cost =  totalPeople * flight_first_class; 
          break;
        
        default:
          break;
      }

      PrintFlight(flight_id, flight_from, flight_to,flight_departure_date,flight_departure_time,flight_arrival_date,flight_arrival_time,flight_company,flight_stages,total_cost,flight_seats,totalPeople)
    }

  }
</script>
<?php
    $starttime = microtime(true);
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
      $get_flight_from = $_GET["flight_from"];
      $get_flight_class = $_GET["flight_class"];
      $get_flight_departure = $_GET["flight_depart"];
      $get_flight_arrival = $_GET["flight_arrival"];
      $get_flight_adults = $_GET["flight_adults"];
      $get_flight_childs = $_GET["flight_childs"];
      
      $total_people = (int) $get_flight_adults + (int) $get_flight_childs;


      
      //echo "<script>var </script>";
      echo "<script>getData('".$get_flight_departure."','".$get_flight_arrival."','".$get_flight_from."','".$total_people."','".$get_flight_class."');</script>";
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

<script>
  var company_logo = {"ryanair": "https://q-xx.bstatic.com/data/airlines_logo/square_96/FR.png", "wizz_air": "https://q-xx.bstatic.com/data/airlines_logo/square_96/W6.png", "ita_airlines": "https://q-xx.bstatic.com/data/airlines_logo/square_96/AZ.png", "easyjet": "https://q-xx.bstatic.com/data/airlines_logo/square_96/U2.png", "air_france": "https://q-xx.bstatic.com/data/airlines_logo/square_96/AF.png", "lufthansa": "https://q-xx.bstatic.com/data/airlines_logo/square_96/LH.png", "swiss": "https://q-xx.bstatic.com/data/airlines_logo/square_96/LX.png", "vueling": "https://q-xx.bstatic.com/data/airlines_logo/square_96/VY.png"};
  var show_less = {"ryanair": "Ryanair", "ita_airways": "ITA Airways", "lufthansa": "Lufthansa", "easyjet": "Easyjet"};
  var show_more = {"wizz_air": "Wizz Air", "swiss": "Swiss", "vueling": "Vueling", "air_france": "Air France"};
  function ShowMoreCompany(type) {
    if (type == 'show') {
      for (const [key, value] of Object.entries(show_more)) {
        var element = `<label class="form-check mb-1">
          <input type="checkbox" class="form-check-input" name="form-company[]" value="${key}" checked="">
          <span class="form-check-label">${value}</span>
        </label>`;
        document.getElementById('show_more_company').innerHTML += element;
      }
      var text = `<a onclick="ShowMoreCompany('less')" class="small text-info" id="show_more_text">Show less</a>`;
      document.getElementById('show_more_text_div').innerHTML = text;
    } else {
      document.getElementById('show_more_company').innerHTML = "";
      for (const [key, value] of Object.entries(show_less)) {
        var element = `<label class="form-check mb-1">
          <input type="checkbox" class="form-check-input" name="form-company[]" value="${key}" checked="">
          <span class="form-check-label">${value}</span>
        </label>`;
        document.getElementById('show_more_company').innerHTML += element;
      }
      var text = `<a onclick="ShowMoreCompany('show')" class="small text-info" id="show_more_text">Show more</a>`;
      document.getElementById('show_more_text_div').innerHTML = text;
    }
  }
</script>

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
              <div class="row">
                <div class="col-lg-12">
                  <div class="mb-3">
                    <label class="form-label">Depart</label>
                    <div class="input-icon mb-3">
                      <span class="input-icon-addon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plane-departure" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                          <path d="M15 12h5a2 2 0 0 1 0 4h-15l-3 -6h3l2 2h3l-2 -7h3z" transform="rotate(-15 12 12) translate(0 -1)"></path>
                          <line x1="3" y1="21" x2="21" y2="21"></line>
                        </svg>
                      </span>
                      <input type="text" class="form-control" value="" id="searched_from" readonly="">
                    </div>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="mb-3">
                    <label class="form-label">Arrival</label>
                    <div class="input-icon mb-3">
                      <span class="input-icon-addon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plane-arrival" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                          <path d="M15 12h5a2 2 0 0 1 0 4h-15l-3 -6h3l2 2h3l-2 -7h3z" transform="rotate(15 12 12) translate(0 -1)"></path>
                          <line x1="3" y1="21" x2="21" y2="21"></line>
                        </svg>
                      </span>
                      <input type="text" class="form-control" value="" id="searched_to" readonly="">
                    </div>
                  </div>
                </div>
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

  <?php
    echo "<script>document.getElementById('searched_from').value = '$get_flight_departure'; document.getElementById('searched_to').value = '$get_flight_arrival';</script>";
    $endtime = microtime(true);
    $loading_page_time = $endtime - $starttime;
    
  ?>
  <script>
    if (search_result_number == 0) {
      document.getElementById('flight_list').innerHTML = `<div class="empty">
          <div class="empty-header"><img src="img/no_flights_found.png" width="350" height="200"></div>
          <p class="empty-title">Oops… no flights found</p>
          <p class="empty-subtitle text-muted">
            Search other destinations or retry later
          </p>
        </div>`;
    }
    document.addEventListener("DOMContentLoaded", function () {
      var load_time = "<?php echo $loading_page_time; ?>";
      document.getElementById('page_loading_time_results').innerHTML = 'Found '+search_result_number+' results ('+Math.round(load_time * 1000) / 1000+' seconds)';
    });
  </script>
</body>

</html>