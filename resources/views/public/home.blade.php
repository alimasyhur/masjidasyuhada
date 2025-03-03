@extends('layouts.public')

@section('title', 'Event')

@section('header')
Home Ramadhan Fest
@endsection

@section('content')
<div class="row">
    <img src="{{ asset('assets/img/senyum-sehat.jpeg') }}" alt="Image" class="img-thumbnail" width="100%">
    <div class="col-md-2"></div>
    <div class="col-md-8">
    </div>
    <div class="col-md-2"></div>
    <div class="text-center">
        <hr>
        <br>
        <h1><strong>Program & Events</strong></h1>
        <br>
        <p>Berikut ini adalah daftar Program dan Events Ramadhan Fest Masjid Sejuta Pemuda. Untuk lebih detail dan mendaftar eventnya bisa klik
            <br><a href="/event" class="btn btn-primary btn-lg">menu event</a>
        </p>
    </div>
    <img src="{{ asset('assets/img/ramadhanfest3.jpeg') }}" alt="Image" class="img-thumbnail" width="100%">
</div>
@endsection
