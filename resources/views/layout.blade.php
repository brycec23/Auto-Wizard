<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Auto Wizard</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>
<body>
    <div class="container-fluid">
        <div class="d-flex align-items-center ms-5 mt-3">
            <img src="wizard.svg" alt="Auto Wizard Logo" width="60" height="60" class="me-3">
            <h1 class="display-3 mb-0">Auto Wizard</h1>
        </div>
        
        @yield('content')
        
        <footer class="text-center text-white fixed-bottom bg-primary">
            <div class="text-center p-3" >
              © 2023 Copyright:
              <a class="text-white" href="https://brycecullen.dev/">brycecullen.dev</a>
            </div>
        </footer>
    </div>
</body>

</html>