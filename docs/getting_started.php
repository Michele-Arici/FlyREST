

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
          <img src="../img/logo_piccolo.png" alt="FlyREST" class="navbar-brand-image" width="110" height="32">
        </a>
      </h1>

      <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="../main.php">
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
            <li class="nav-item active">
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
            <li class="nav-item">
              <a class="nav-link" href="../admin.php">
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

<div class="page-wrapper">
        <div class="container-xl">
          <!-- Page title -->
          <div class="page-header d-print-none">
            <div class="row align-items-center">
              <div class="col">
                <h2 class="page-title">
                  Documentation
                </h2>
              </div>
            </div>
          </div>
        </div>
        <div class="page-body">
          <div class="container-xl">
            <div class="row gx-lg-4">
              <div class="d-none d-lg-block col-lg-3">
                <ul class="nav nav-pills nav-vertical">
                  <li class="nav-item">
                    <a href="../docs/index.php" class="nav-link">
                      Introduction
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../docs/getting_started.php" class="nav-link active" aria-expanded="false">
                      Getting started
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../docs/pages.php" class="nav-link" aria-expanded="false">
                      Pages
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../docs/methods.php" class="nav-link" aria-expanded="false">
                      Methods
                    </a>
                  </li>
                </ul>
              </div>
              <div class="col-lg-9">
                <div class="card card-lg">
                    <div class="card-body">
                        <div class="markdown">
                        <div>
                            <div class="d-flex mb-3">
                            <h1 class="m-0">Getting started</h1>
                            </div>
                        </div>
                        <h2 id="set-up-the-environment">Installare l'ambiente</h2>
                        <h3 id="windows-users">Requisiti per avviare il progetto:</h3>
                        <ul>
                            <li>Xampp</li>
                            <li>Visual Studio Code</li>
                            <li>Node</li>
                        </ul>
                        <h3 id="windows-users">Setup per Windows</h3>
                        <ol>
                            <li>Inserire la cartella del progetto in <code class="language-plaintext highlighter-rouge">C:\xampp\htdocs</code></li>
                            <li>Aprire xampp control panel ed avviare i moduli Apache e MySQL</li>
                            <li>Aprire la cartella inserita precedentemente in htdocs su Visual Studio Code</li>
                            <li>Avviare un nuovo terminale come nella seguente immagine</li>
                        </ol>
                        <img src="..\img\newterminal.png">
                        <p>Una volta completato il setup, scrivere nel terminale <code class="language-plaintext highlighter-rouge">node JSONServer.js</code></p>
                        <h2 id="build-tabler-locally">Aprire il sito web</h2>
                        <p>Collegarsi a localhost : porta del vostro Xampp / FlyREST</p>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</body>
</html>