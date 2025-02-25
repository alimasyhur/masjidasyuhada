@extends('layouts.public')

@section('title', 'Event')

@section('header')
    Home Ramadhan Fest
@endsection

@section('content')
    <div class="row">
        <img src="{{ asset('assets/img/ramadhanfest2.jpeg') }}" alt="Image" class="img-thumbnail" width="100%">
        <div class="text-center">
            <br>
            <h1><strong>Program & Events</strong></h1>
            <br>
            <p>Berikut ini adalah daftar Program dan Events Ramadhan Fest Masjid Sejuta Pemuda. Untuk lebih detail dan mendaftar eventnya bisa klik
                <a href="/event" class="btn btn-primary">menu event</a>
            </p>
        </div>
        <img src="{{ asset('assets/img/ramadhanfest3.jpeg') }}" alt="Image" class="img-thumbnail" width="100%">
    </div>
@endsection
