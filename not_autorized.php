<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>FlyREST</title>

    <script src="https://unpkg.com/@tabler/core@1.0.0-beta4/dist/js/tabler.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/@tabler/core@1.0.0-beta4/dist/css/tabler.min.css">
</head>

<body class="d-flex flex-column">
    <div class="page page-center">
        <div class="container-tight py-4">
            <div class="empty">
                <div class="empty-header">Oops...</div>
                <p class="empty-title">You are not autorized to stay here</p>
                <p class="empty-subtitle text-muted">
                    Click the button to go back
                </p>
                <div class="empty-action">
                    <a href="sign-in.php" class="btn btn-primary">
                    <!-- Download SVG icon from http://tabler-icons.io/i/arrow-left -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><line x1="5" y1="12" x2="19" y2="12"></line><line x1="5" y1="12" x2="11" y2="18"></line><line x1="5" y1="12" x2="11" y2="6"></line></svg>
                        Take me back
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://browser.sentry-cdn.com/5.27.6/bundle.tracing.min.js" integrity="sha384-9Z8PxByVWP+gIm/rTMPn9BWwknuJR5oJcLj+Nr9mvzk8nJVkVXgQvlLGZ9SIFEJF" crossorigin="anonymous"></script>
    <script>
        Sentry.init({
            dsn: "https://8e4ad02f495946f888620f9fb99fd495@o484108.ingest.sentry.io/5536918",
            release: "tabler@1.0.0-beta4",
            integrations: [
                new Sentry.Integrations.BrowserTracing()
            ],
        
            tracesSampleRate: 1.0,
        });
    </script>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="./dist/js/tabler.min.js?1637753930"></script>
    <?php
        //sleep(5);
        //header('Location: '. 'sign-in.php');
    ?>
      
</body>

</html>