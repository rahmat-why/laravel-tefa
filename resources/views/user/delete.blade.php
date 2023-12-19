@extends('layouts.app')

@section('title', 'Apakah anda yakin ingin menonaktifkan akun ini?')

@section('content')

<div>
    <dl class="row">
        <dt class="col-sm-2">
            Nama Lengkap
        </dt>
        <dd class="col-sm-10">
            {{ $msUser->full_name }}
        </dd>
        <dt class="col-sm-2">
            Nim
        </dt>
        <dd class="col-sm-10">
            {{ $msUser->nim }}
        </dd>
        <dt class="col-sm-2">
            Username
        </dt>
        <dd class="col-sm-10">
            {{ $msUser->username }}
        </dd>
        <dt class="col-sm-2">
            Posisi
        </dt>
        <dd class="col-sm-10">
            {{ $msUser->position }}
        </dd>
    </dl>
    
    <form method="post" action="{{ route('user.destroy', $msUser->id_user) }}">
        @csrf
        @method('DELETE')
        <button type="submit" name="deleteButton" class="btn btn-danger">Nonaktifkan</button> |
        <a href="{{ route('user.index') }}">Kembali</a>
    </form>
</div>
@endsection
