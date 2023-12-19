@extends('layouts.app')

@section('title', 'Akun Mekanik')

@section('content')

<p>
    <a href="{{ route('user.create') }}">Tambah Akun</a>
</p>

@if (session('SuccessMessage'))
    <div class="alert alert-success" role="alert">
        {{ session('SuccessMessage') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<table class="table">
    <thead>
        <tr>
            <th>
                Nama Ketua
            </th>
            <th>
                NIM
            </th>
            <th>
                Username
            </th>
            <th>
                Posisi
            </th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>
                    {{ $user->full_name }}
                </td>
                <td>
                    {{ $user->nim }}
                </td>
                <td>
                    {{ $user->username }}
                </td>
                <td>
                    {{ $user->position }}
                </td>
                <td>
                    <a href="{{ route('user.edit', $user->id_user) }}">Ubah</a> |
                    <a href="{{ route('user.delete.form', $user->id_user) }}">Nonaktifkan</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
