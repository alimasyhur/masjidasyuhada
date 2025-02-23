@extends('adminlte::page')

@section('title', 'Edit Event')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Edit Event</h1>
        </div>
        <div class="card-body">

            <form action="{{ route('dashboard.events.update', $event) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Title:</label>
                    <input type="text" name="title" class="form-control" value="{{ $event->title }}" required>
                </div>

                <div class="form-group">
                    <label>Description:</label>
                    <textarea name="description" class="form-control" required>{{ $event->description }}</textarea>
                </div>

                <div class="form-group">
                    <label>Broadcast Text:</label>
                    <input type="text" name="broadcast_text" class="form-control" value="{{ $event->broadcast_text }}" required>
                </div>

                <div class="form-group">
                    <label>Image First URL:</label>
                    <input type="text" name="image_first" class="form-control" value="{{ $event->image_first }}" required>
                </div>

                <div class="form-group">
                    <label>Image Second URL:</label>
                    <input type="text" name="image_second" class="form-control" value="{{ $event->image_second }}" required>
                </div>

                <div class="form-group">
                    <label>Point:</label>
                    <input type="number" name="point" class="form-control" value="{{ $event->point }}" required>
                </div>

                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('dashboard.events.index') }}" class="btn btn-secondary">Back</a>
            </form>

        </div>
    </div>
@endsection
