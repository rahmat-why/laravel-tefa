@extends('layouts.app')

@section('title', 'Details')

@section('content')

<h1>Details</h1>

<div>
    <h4>MsUser</h4>
    <hr />
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
            Nidn
        </dt>
        <dd class="col-sm-10">
            {{ $msUser->nidn }}
        </dd>
        <dt class="col-sm-2">
            Username
        </dt>
        <dd class="col-sm-10">
            {{ $msUser->username }}
        </dd>
        <dt class="col-sm-2">
            Password
        </dt>
        <dd class="col-sm-10">
            {{ $msUser->password }}
        </dd>
        <dt class="col-sm-2">
            Posisi
        </dt>
        <dd class="col-sm-10">
            {{ $msUser->position }}
        </dd>
    </dl>
</div>

<div>
    <a href="{{ route('user.edit', $msUser->id_user) }}">Edit</a> |
    <a href="{{ route('user.index') }}">Back to List</a>
</div>
@endsection
