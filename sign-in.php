<?php
// Start the session
session_start();
?>
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
            <div class="text-center mb-4">
                <a href="."><img src="./static/logo.svg" height="36" alt=""></a>
            </div>
            <form class="card card-md" method="POST" autocomplete="off">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Login to your account</h2>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input name="username" type="text" class="form-control" placeholder="Enter username">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">
                            Password
                            <span class="form-label-description">
                                <a href="./forgot-password.html">I forgot password</a>
                            </span>
                        </label>
                        <div class="input-group input-group-flat">
                            <input name="password" type="password" class="form-control" placeholder="Password" autocomplete="off">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-check">
                            <input type="checkbox" class="form-check-input">
                            <span class="form-check-label">Remember me on this device</span>
                        </label>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Sign in</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://browser.sentry-cdn.com/5.27.6/bundle.tracing.min.js"
        integrity="sha384-9Z8PxByVWP+gIm/rTMPn9BWwknuJR5oJcLj+Nr9mvzk8nJVkVXgQvlLGZ9SIFEJF"
        crossorigin="anonymous"></script>
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
    <?php
        $username = $password = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $username = test_input($_POST["username"]);
          $password = test_input($_POST["password"]);
            
            if (isset($username) && isset($password)) {
                if ($username == "admin" && $password == "admin") {
                    header('Location: '. 'admin.php');
                    $_SESSION['username']='admin';
                }
            }
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="./dist/js/tabler.min.js?1637753930"></script>

</body>

</html>