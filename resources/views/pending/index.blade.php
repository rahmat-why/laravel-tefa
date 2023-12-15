<!-- resources/views/riwayat_kendaraan.blade.php -->

@extends('layouts.app')

@section('title', 'Riwayat Pending')

@section('content')
    @if ($repair_status === 'PENDING')
           <p> Pending sedang berlangsung!</p>
           <a href="{{ route('booking.history.form') }}" class="btn btn-secondary btn-sm w-100 py-2 fs-4 rounded-2 mt-3">Kembali</a>
    @else
    <form method="post" action="{{ route('Pending.start') }}">
            @csrf
            <input type="hidden" name="id_booking" value="{{ $id_booking }}">
            <div class="mb-3">
                <label for="reason" class="control-label">Alasan</label>
                <input type="text" name="reason" class="form-control" />
                @error('reason')
                    <span class="text-danger">{{ $message }}</span>
                @enderror         
            </div>
            @if($repair_status=='INSPECTION LIST'||$repair_status=='EKSEKUSI'||$repair_status=='KONTROL')
                <div class="text-end">
                    <button type="submit" class="btn btn-primary mb-4 ms-auto">Simpan</button>
                </div>
            @else
                <div class="text-end">
                    <a href="{{ route('booking.history.form') }}" class="btn btn-primary mb-4 ms-auto">Kembali</a>
                </div>
             @endif
        </form>
    @endif
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>Alasan</th>
                <th>Mulai Pending</th>
                <th>Selesai Pending</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pending as $pending)
                <tr>
                    <td>{{ $pending->reason ?:'-' }}</td>
                    <td>
                        @if ($pending->start_time)
                            {{ \Carbon\Carbon::parse($pending->start_time)->format('d F Y - H:i') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if ($pending->finish_time === null)
                            <form action="{{ route('Pending.stop', ['id_pending' => $pending->id_pending]) }}" method="POST" onsubmit="return confirm('Apakah anda yakin untuk melanjutkan servis ini?');">
                                @csrf
                                @method('PUT')
                                <button type="submit" style="color: blue; text-decoration: none; border: none; background: none; cursor: pointer;">
                                    Lanjut Servis
                                </button>
                            </form>
                        @else
                        {{ \Carbon\Carbon::parse($pending->finish_time)->format('d F Y - H:i') }}
                        @endif
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="3">No booking records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection

