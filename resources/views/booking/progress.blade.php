@php
    $currentDatetime = now()->format('d F Y - H:i');
    $bookings = $bookings->sortByDesc('progress');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Progress - TEFA</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/logo-favicon.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
</head>
<body>
    <!--  Body Wrapper -->
    <div class="container">
        <br />
        <a href="{{ route('booking.history.form') }}" class="btn btn-outline-primary mb-4 ms-auto">
            Kembali
        </a>

        <div class="row justify-content-between">
            <div class="col-10">
                <b>Progres</b>
            </div>
            <div class="col-2">
                <b>Estimasi Selesai</b>
            </div>
        </div>

        @foreach ($bookings as $item)
            <div class="row mt-2 justify-content-between" id="{{ $item->id_booking }}">
                <div class="col-10 position-relative">
                    <div class="progress">
                        @if ($item->idVehicleNavigation->classify == "MOTOR")
                            <i class="ti ti-motorbike position-absolute text-black" style="left: calc({{ $item->progress }}% - 30px); top: -10px; font-size: 30px;"></i>
                        @else
                            <i class="ti ti-car position-absolute text-black" style="left: calc({{ $item->progress }}% - 30px); top: -10px; font-size: 30px;"></i>
                        @endif
                        <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{ $item->progress }}%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                            {{ $item->repair_status }} ({{ $item->progress }}%)
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    @php
                        $name = optional(optional($item->idVehicleNavigation)->idCustomerNavigation)->name;
                    @endphp
                    <div style="font-weight: bold;">
                        {{ $name ?? 'N/A' }}
                    </div>
                    <div>
                        {{ optional($item->finish_estimation_time)->format('d F Y - H:i') ?? 'N/A' }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script src="{{ asset('Content/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('Content/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('Content/assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('Content/assets/js/app.min.js') }}"></script>
    <script src="{{ asset('Content/assets/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('Content/assets/js/dashboard.js') }}"></script>
</body>
</html>
