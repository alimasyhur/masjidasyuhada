@extends('adminlte::page')

@section('title', 'Event Detail')

@section('content_header')
    <h1>Event Detail</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>{{ $event->title }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Description:</strong> {{ $event->description }}</p>
            <p><strong>Broadcast Text:</strong> {{ $event->broadcast_text }}</p>
            <p><strong>Point:</strong> {{ $event->point }}</p>
            <p><strong>Images:</strong></p>
            <img src="{{ $event->image_first }}" alt="First Image" class="img-fluid" style="max-width: 200px;">
            <img src="{{ $event->image_second }}" alt="Second Image" class="img-fluid" style="max-width: 200px;">
        </div>
        <div class="card-footer">
            <a href="{{ route('dashboard.events.index') }}" class="btn btn-secondary">Back</a>
            <a href="{{ route('dashboard.events.edit', $event) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('dashboard.events.destroy', $event) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this event?')">Delete</button>
            </form>
        </div>
    </div>
@endsection
