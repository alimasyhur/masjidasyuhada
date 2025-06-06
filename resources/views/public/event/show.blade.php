@extends('layouts.public')

@section('title', 'Detail Event')

@section('content_header')
    <h1>Detail Event</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>{{ $event->title }}</h3>
        </div>
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <img src="{{ $event->image_first }}" alt="First Image" class="img-fluid" style="max-width: 200px;">
            <img src="{{ $event->image_second }}" alt="Second Image" class="img-fluid" style="max-width: 200px;">
            <pre> {{ $event->description }}</pre>
        </div>
        <div class="card-footer">
            @if($isLoginRelawan)

            @elseif($isLogin)
                @if($isRegistered)
                    <a href="#" class="btn btn-info">Anda sudah mendaftar</a>
                @else
                    <a href="{{ route('event.register', $event) }}" class="btn btn-success">Mendaftar Event</a>
                @endif
            @else
                <a href="{{ route('public.members.login') }}" class="btn btn-success">Login untuk Mendaftar Event</a>
            @endif
            <a href="{{ route('event') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
@endsection
