<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TEFA') - TEFA</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/logo-favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
</head>
<body>
    
<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
  data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div>
            <div class="brand-logo d-flex align-items-center justify-content-between">
                <a href="./index.html" class="text-nowrap logo-img">
                    <h6 class="text-left">
                        <img src="{{ asset('assets/images/logos/logo.png') }}" width="40" alt="TEFA Politeknik Astra">
                        <b>TEACHING FACTORY</b>
                    </h6>
                </a>
                <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                    <i class="ti ti-x fs-8"></i>
                </div>
            </div>
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                <ul id="sidebarnav">
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">{{ auth()->user()->full_name }} - {{ auth()->user()->position }}</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('booking.history.form') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-layout-dashboard"></i>
                            </span>
                            <span class="hide-menu">Daftar Booking </span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('booking.progres.form') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-article"></i>
                            </span>
                            <span class="hide-menu">Servis Berjalan</span>
                        </a>
                    </li>
                    @if(auth()->user()->position == "SERVICE ADVISOR")
                    <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('booking.report.form') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-alert-circle"></i>
                            </span>
                            <span class="hide-menu">Laporan Booking</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('user.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-cards"></i>
                            </span>
                            <span class="hide-menu">Akun Mekanik</span>
                        </a>
                    </li>
                    @endif
                </ul>
                <div class="unlimited-access hide-menu position-relative mb-7 mt-5 rounded">
                    <div class="d-flex">
                        <div class="unlimited-access-title me-3">
                            <a href="{{ route('user.logout.process') }}" class="btn btn-primary fs-2 fw-semibold lh-sm">Logout</a>
                        </div>
                    </div>
                </div>
            </nav>
        <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
        <!--  Header Start -->
        <header class="app-header">
            <nav class="navbar navbar-expand-lg navbar-light">
                <ul class="navbar-nav">
                    <li class="nav-item d-block d-xl-none">
                        <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <b>
                            @yield('title', 'TEFA')                         
                        </b>
                    </li>
                </ul>
            </nav>
        </header>
        <!--  Header End -->
        <div class="container-fluid">
            <!--  Row 1 -->
            <div class="row">
                <div class="col-lg-12 d-flex align-items-strech">
                    <div class="card w-100">
                        <div class="card-body">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
<script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
<script src="{{ asset('assets/js/dashboard.js') }}"></script>

<script>
    function copyPhone(button) {
        var phoneNumber = $(button).data('phone');

        // Create a temporary input element
        var tempInput = $('<input>');
        $('body').append(tempInput);

        // Set the value of the input to the phone number
        tempInput.val(phoneNumber);

        // Select and copy the text from the input
        tempInput.select();
        document.execCommand('copy');

        // Remove the temporary input element
        tempInput.remove();

        // You can provide feedback to the user, e.g., show a tooltip or alert
        alert('Nomor whatsapp berhasil disalin: ' + phoneNumber);
    }
</script>
      
</body>
</html>