@extends('layouts.public')

@section('title', 'Event')

@section('header')
    Event
@endsection

@section('content')
    <h1>Events</h1>
    @foreach ($events as $event)
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-body d-flex align-items-center">
                    <div class="row">
                        <div class="col-3">
                            <img src="{{ $event->image_first }}" alt="Image" class="img-thumbnail">
                        </div>
                        <div class="col-7">
                            <h5 class="card-title">{{ $event->title }}</h5>
                            <pre class="card-text">{{ $event->description }}</pre>
                        </div>
                        <div class="col-2">
                            <a href="{{ route('event.show', $event) }}" class="btn btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    @endforeach
@endsection
