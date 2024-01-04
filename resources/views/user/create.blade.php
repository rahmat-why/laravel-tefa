@extends('layouts.app')

@section('title', 'Tambah Akun')

@section('content')

@if (session('errorMessage'))
    <div class="alert alert-danger" role="alert">
        {{ session('errorMessage') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form method="post" action="{{ route('user.create.process') }}">
    @csrf
    <div class="mb-3">
        <label for="full_name" class="control-label">Nama Lengkap</label>@error('full_name')<span class="text-danger">{{ $message }}</span>@enderror
        <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}" />
    </div>
    <div class="mb-3">
        <label for="position" class="control-label">Posisi</label>@error('position')<span class="text-danger">{{ $message }}</span>@enderror
        <select name="position" class="form-control" id="position">
            <option value="HEAD MECHANIC">HEAD MECHANIC</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="nim" class="control-label">NIM</label>@error('nim')<span class="text-danger">{{ $message }}</span>@enderror
        <input type="text" name="nim" class="form-control" value="{{ old('nim') }}" />
    </div>
    <div class="mb-3">
        <label for="username" class="control-label">Username</label>@error('username')<span class="text-danger">{{ $message }}</span>@enderror
        <input type="text" name="username" class="form-control" value="{{ old('username') }}" />
    </div>
    <div class="mb-3">
        <label for="password" class="control-label">Password</label>@error('password')<span class="text-danger">{{ $message }}</span>@enderror
        <input type="password" name="password" class="form-control" />
    </div>

    <button type="submit" class="btn btn-primary btn-sm w-100 py-2 fs-4 rounded-2">Simpan</button>
    <div class="mt-3">
        <a href="{{ route('user.index') }}" class="btn btn-outline-dark btn-sm w-100 py-2 fs-4 mb-4 rounded-2">Kembali</a>
    </div>
</form>
@endsection
