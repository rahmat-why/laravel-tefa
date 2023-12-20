<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - TEFA</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/logo-favicon.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
</head>
<body>
<style>
    #loadingSpinner {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
        background-color: #f8f9fa; /* Set your desired background color */
        padding: 10px; /* Add padding for better visibility */
        border-radius: 5px; /* Optional: Add rounded corners */
    }
</style>

<nav class="navbar navbar-expand-lg" style="background-color: #ffffff;">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="text-left">
            <img src="{{ asset('assets/images/logos/logo.png') }}" width="40" alt="TEFA Politeknik Astra">
            <b>TEACHING FACTORY</b>
        </div>
    </div>
</nav>

<div class="container-fluid">
    @yield('content')
</div>

<footer class="border-top footer text-muted">
    <div class="py-6 px-6 text-center">
        <p class="mb-0 fs-4">Developed by <b>Astra Polytechnic</b></p>
    </div>
</footer>

<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>
<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
<script src="{{ asset('assets/js/dashboard.js') }}"></script>
      

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var form = document.querySelector("form");
        var loadingSpinner = document.getElementById("loadingSpinner");

        form.addEventListener("submit", function () {
            // Show loading spinner on form submission
            loadingSpinner.style.display = "block";
        });
    });
</script>

</body>
</html>