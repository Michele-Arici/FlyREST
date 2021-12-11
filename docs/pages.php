

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
                    <a href="../docs/getting_started.php" class="nav-link" aria-expanded="false">
                      Getting started
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../docs/pages.php" class="nav-link active" aria-expanded="false">
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
                            <h1 class="m-0">Documentazione</h1>
                            </div>
                        </div>
                        <p>Una volta avviato il server le pagine principali del progetto sono due: </p>
                        <ul>
                            <li>Amministratore</li>
                            <li>Utente</li>
                        </ul>

                        <h2 id="what-are-the-benefits">Amministratore</h2>
                        <p>Per loggare come amministratore è necessario fare il login (Username: admin / password: admin), una volta loggato l’amministratore potrà creare dei nuovi voli compilando il seguente form: </p>
                        <img src="..\img\createf.png">
                        <p>L’altra funzione dell’amministratore è quella della rimozione dei voli, infatti una volta premuto il bottone “remove flight” apparirà una pagina dove è possibile scegliere nell’elenco dei voli presenti quali rimuovere.</br></p>
                        <br>
                        <br><h2 id="what-are-the-benefits">Utente</h2>
                        <p>Nella parte dell’utente invece sarà possibile cercare un volo tramite i parametri: luogo di partenza, luogo di arrivo, la data di partenza, la scelta della classe, numero di adulti e di bambini. </br>
                        Una volta avviata la ricerca produrrà come risultato l’elenco dei biglietti se esistenti. </p>
                        <img src="..\img\Utente.png">
                      </p>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</body>
</html>