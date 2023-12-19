@extends('layouts.app')

@section('title', 'Ubah Akun')

@section('content')

@if (session('ErrorMessage'))
    <div class="alert alert-danger" role="alert">
        {{ session('ErrorMessage') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form method="post" action="{{ route('user.update', $msUser->id_user) }}">
    @csrf
    @method('POST')

    <div class="mb-3">
        <label for="full_name" class="control-label">Nama Lengkap</label>
        <input type="text" name="full_name" class="form-control" value="{{ $msUser->full_name }}" />
        <span class="text-danger">{{ $errors->first('full_name') }}</span>
    </div>

    <div class="mb-3">
        <label for="position" class="control-label">Posisi</label>
        <select name="position" class="form-control">
            <option value="HEAD MECHANIC" {{ $msUser->position == 'HEAD MECHANIC' ? 'selected' : '' }}>HEAD MECHANIC</option>
        </select>
        <span class="text-danger">{{ $errors->first('position') }}</span>
    </div>

    <div class="mb-3">
        <label for="nim" class="control-label">NIM</label>
        <input type="text" name="nim" class="form-control" value="{{ $msUser->nim }}" />
        <span class="text-danger">{{ $errors->first('nim') }}</span>
    </div>

    <div class="mb-3">
        <label for="username" class="control-label">Username</label>
        <input type="text" name="username" class="form-control" value="{{ $msUser->username }}" readonly />
        <span class="text-danger">{{ $errors->first('username') }}</span>
    </div>

    <div class="mb-3">
        <label for="password" class="control-label">Password</label>
        <input type="password" name="password" class="form-control" value="" />
        <div id="paswordhelp" class="form-text">Kosongkan password jika tidak ingin diubah</div>
        <span class="text-danger">{{ $errors->first('password') }}</span>
    </div>

    <br />

    <button type="submit" class="btn btn-primary btn-sm w-100 py-2 fs-4 rounded-2">Simpan</button>

    <div class="mt-3">
        <a href="{{ route('user.index') }}" class="btn btn-outline-dark btn-sm w-100 py-2 fs-4 mb-4 rounded-2">Kembali</a>
    </div>
</form>
@endsection
