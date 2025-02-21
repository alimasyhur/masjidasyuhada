@extends('layouts.public')

@section('title', 'Event')

@section('header')
    Home Ramadhan Fest
@endsection

@section('content')
    <div class="row">
        <img src="{{ asset('assets/img/ramadhanfest2.jpeg') }}" alt="Image" class="img-thumbnail" width="100%">
        <img src="{{ asset('assets/img/ramadhanfest3.jpeg') }}" alt="Image" class="img-thumbnail" width="100%">
    </div>
@endsection
