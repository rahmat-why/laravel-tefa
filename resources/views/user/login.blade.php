<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TEFA') - TEFA</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/logo-favicon.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
</head>
<body>

<!-- Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
     data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-75">
            <div class="row justify-content-center w-100">
                <div class="col-md-8 col-lg-6 col-xxl-3">
                    <div class="card mb-0">
                        <div class="card-body">
                            <span class="text-nowrap logo-img text-center d-block py-4 w-100">
                                <img src="{{ asset('assets/images/logos/logo.png') }}" width="60" alt="TEFA Politeknik Astra">
                            </span>
                            <h5 class="text-center"><b>TEACHING FACTORY<br />MESIN OTOMOTIF</b></h5>
                            <p class="text-center">
                                Proses praktik perbaikan kendaraan Mahasiswa Mesin Otomotif
                            </p>
                            @if (session('ErrorMessage'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('ErrorMessage') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            <form action="{{ route('user.login.process') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp" required>
                                    <span class="text-danger">{{ $errors->first('username') }}</span>
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp" required>
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm w-100 py-2 fs-4 mb-4 rounded-2">
                                    Login
                                </button>
                            </form>
                        </div>
                        <p class="text-center mt-5">
                            <b>{{ now()->format('d F Y - H:i') }}</b>
                        </p>
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
<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
<script src="{{ asset('assets/js/dashboard.js') }}"></script>
      
</body>
</html>