

<head>
  <meta charset="utf-8">
  <title>FlyREST</title>

  <script src="https://unpkg.com/@tabler/core@1.0.0-beta4/dist/js/tabler.min.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/@tabler/core@1.0.0-beta4/dist/css/tabler.min.css">

</head>

<body>

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