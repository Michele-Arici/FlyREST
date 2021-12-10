<?php
    $csv = array_map('str_getcsv', file('airports.csv'));
    array_walk($csv, function(&$a) use ($csv) {
    $a = array_combine($csv[0], $a);
    });
    array_shift($csv);
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
            <li class="nav-item active">
              <a class="nav-link" href="">
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
              <a class="nav-link" href="../docs/index.php">
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
          </ul>
        </div>
      </div>
    </div>
  </header>

  <header class="masthead"
    style="height: 100vh; min-height: 500px; background-image: url('https://wallpaperaccess.com/full/254381.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="container h-100">
      <div class="row h-100 align-items-center">
        <div class="col-sm-2"></div>
        <div class="col-8">
          <div class="card">
            <form action="results.php" method="get">
                <div class="card-header" style="display: block;">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h2 class="page-title">
                                Go where you want
                            </h2>
                        </div>
                        <div class="col-auto ms-auto">
                            <button type="submit" class="btn btn-primary">Search flight</button>
                        </div>
                    </div>
                </div>    
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Depart</label>
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 12h5a2 2 0 0 1 0 4h-15l-3 -6h3l2 2h3l-2 -7h3z" transform="rotate(-15 12 12) translate(0 -1)" /><line x1="3" y1="21" x2="21" y2="21" /></svg>
                                    </span>
                                    <input class="form-control" list="datalistOptions" name="flight_depart" placeholder="Type to search... " required> 
                                </div>
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
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Arrival</label>
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 12h5a2 2 0 0 1 0 4h-15l-3 -6h3l2 2h3l-2 -7h3z" transform="rotate(15 12 12) translate(0 -1)" /><line x1="3" y1="21" x2="21" y2="21" /></svg>
                                    </span>
                                    <input class="form-control" list="datalistOptions" name="flight_arrival" placeholder="Type to search..." required>
                                </div>
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
                        <div class="col-4">
                            <div class="mb-3">
                                <label class="form-label">From</label>
                                <input type="date" class="form-control" placeholder="Select a date" name="flight_from" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label class="form-label">Class </label>
                                <select class="form-select" name="flight_class">
                                    <option value="economy_class">Economy class</option>
                                    <option value="second_class">Second class</option>
                                    <option value="first_class">First class</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="mb-3">
                                <label class="form-label">Adults</label>
                                <div class="input-icon">
                                    <span class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <circle cx="9" cy="7" r="4" />
                                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                            <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                        </svg>
                                    </span>
                                    <input type="number" class="form-control ms-auto" name="flight_adults" min="1" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="mb-3">
                                <label class="form-label">Childs</label>
                                <div class="input-icon">
                                    <span class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <circle cx="9" cy="7" r="4" />
                                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                            <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                        </svg>
                                    </span>
                                    <input type="number" class="form-control ms-auto" name="flight_childs" min="0" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
          </div>
        </div>
        <div class="col-sm-2"></div>
      </div>
    </div>
  </header>
  <section class="py-5">
    <div class="container">
      <div style="text-align: center;" class="mb-3">
        <h1>Most popular locations</h1>
      </div>
      <div class="row row-cards">
        <div class="col-4">
          <div class="card">
            <div class="card-img-top img-responsive img-responsive-16by9" style="background-image: url(https://img.huffingtonpost.com/asset/60910bc2260000314fb42291.jpg?cache=4Soy36qwIO&ops=scalefit_960_noupscale)"></div>
            <div class="card-body">
              <h2 class="card-title" style="font-weight: bold;">Dubai</h2>
              <p class="text-muted">Voli da Milano Malpensa Airport</p>
              <p class="text-muted"><?php $temp = date("Y-m-d"); $nextweek = new DateTime($temp . ' + 7 day'); echo date("d-m") . " · " . $nextweek->format('d-m') . " Andata e ritorno" ?></p>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="card">
            <div class="card-img-top img-responsive img-responsive-16by9" style="background-image: url(https://www.columbusassicurazioni.it/media/28572/cosa-fare-a-new-york-20-luoghi-e-attrazioni-imperdibili.jpg?width=800)"></div>
            <div class="card-body">
              <h3 class="card-title" style="font-weight: bold;">New York</h3>
              <p class="text-muted">Voli da Milano Malpensa Airport</p>
              <p class="text-muted"><?php $temp = date("Y-m-d"); $nextweek = new DateTime($temp . ' + 7 day'); echo date("d-m") . " · " . $nextweek->format('d-m') . " Andata e ritorno" ?></p>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="card">
            <div class="card-img-top img-responsive img-responsive-16by9" style="background-image: url(https://www.viaggibarcellona.it/wp-content/uploads/2016/12/cosa-vedere-barcellona.jpg)"></div>
            <div class="card-body">
              <h3 class="card-title" style="font-weight: bold;">Barcellona</h3>
              <p class="text-muted">Voli da Milano Malpensa Airport</p>
              <p class="text-muted"><?php $temp = date("Y-m-d"); $nextweek = new DateTime($temp . ' + 7 day'); echo date("d-m") . " · " . $nextweek->format('d-m') . " Andata e ritorno" ?></p>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="card">
            <div class="card-img-top img-responsive img-responsive-16by9" style="background-image: url(https://siviaggia.it/wp-content/uploads/sites/2/2020/08/innamorarsi-napoli.jpg)"></div>
            <div class="card-body">
              <h3 class="card-title" style="font-weight: bold;">Napoli</h3>
              <p class="text-muted">Voli da Milano Malpensa Airport</p>
              <p class="text-muted"><?php $temp = date("Y-m-d"); $nextweek = new DateTime($temp . ' + 7 day'); echo date("d-m") . " · " . $nextweek->format('d-m') . " Andata e ritorno" ?></p>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="card">
            <div class="card-img-top img-responsive img-responsive-16by9" style="background-image: url(https://vittoriosavoia.it/new/wp-content/uploads/2020/01/Colosseo.jpg)"></div>
            <div class="card-body">
              <h3 class="card-title" style="font-weight: bold;">Roma</h3>
              <p class="text-muted">Voli da Milano Malpensa Airport</p>
              <p class="text-muted"><?php $temp = date("Y-m-d"); $nextweek = new DateTime($temp . ' + 7 day'); echo date("d-m") . " · " . $nextweek->format('d-m') . " Andata e ritorno" ?></p>
            </div>
          </div>
        </div>
        <div class="col-4 border-0">
          <div class="card">
            <div class="card-img-top img-responsive img-responsive-16by9" style="background-image: url(https://images.lonelyplanetitalia.it/static/places/maldive-139.jpg?q=90&p=social&s=f57483da1976e6f7677e690ce1d4672f)"></div>
            <div class="card-body">
              <h3 class="card-title" style="font-weight: bold;">Maldive</h3>
              <p class="text-muted">Voli da Milano Malpensa Airport</p>
              <p class="text-muted"><?php $temp = date("Y-m-d"); $nextweek = new DateTime($temp . ' + 7 day'); echo date("d-m") . " · " . $nextweek->format('d-m') . " Andata e ritorno" ?></p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

  <section  class="py-5">
    <div class="container">
      <div class="row">
          <div class="col-2">

          </div>
          <div class="col-8">
            <div id="carousel-controls" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item">
                  <img class="d-block w-100" alt="" src="https://img.huffingtonpost.com/asset/60910bc2260000314fb42291.jpg?cache=4Soy36qwIO&ops=scalefit_960_noupscale">
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" alt="" src="https://img.huffingtonpost.com/asset/60910bc2260000314fb42291.jpg?cache=4Soy36qwIO&ops=scalefit_960_noupscale">
                </div>
                <div class="carousel-item active">
                  <img class="d-block w-100" alt="" src="https://img.huffingtonpost.com/asset/60910bc2260000314fb42291.jpg?cache=4Soy36qwIO&ops=scalefit_960_noupscale">
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" alt="" src="https://img.huffingtonpost.com/asset/60910bc2260000314fb42291.jpg?cache=4Soy36qwIO&ops=scalefit_960_noupscale">
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" alt="" src="https://img.huffingtonpost.com/asset/60910bc2260000314fb42291.jpg?cache=4Soy36qwIO&ops=scalefit_960_noupscale">
                </div>
              </div>
              <a class="carousel-control-prev" href="#carousel-controls" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carousel-controls" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </a>
            </div>
          </div>
          <div class="col-2">

          </div>
      </div>
    </div>
  </section>
  <footer class="footer footer-transparent d-print-none">
    <div class="container-xl">
      <div class="row text-center align-items-center flex-row-reverse">
        <div class="col-lg-auto ms-lg-auto">
          <ul class="list-inline list-inline-dots mb-0">
            <li class="list-inline-item"><a href="documentation.php" class="link-secondary" >Documentation</a></li>
            <li class="list-inline-item"><a class="link-secondary">flyrest@gmail.com</a></li>
          </ul>
        </div>
        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
          <ul class="list-inline list-inline-dots mb-0">
            <li class="list-inline-item">
              Copyright © 2021
              <a href="." class="link-secondary">FlyREST</a>.
              All rights reserved.
            </li>
            <li class="list-inline-item">
              <?php echo "Generated " . date('m/d/Y h:i:s a', time()); ?>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
</body>





</html>