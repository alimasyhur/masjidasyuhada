@extends('adminlte::page')

@section('title', 'Create Event')

@section('content_header')
    <h1>Create Event</h1>
@endsection

@section('content')
    <form action="{{ route('dashboard.events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @if($errors->has('upload_error'))
            <div class="alert alert-danger mt-3">
                {{ $errors->first('upload_error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="form-group">
            <label>Title:</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Description:</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label>Broadcast Text:</label>
            <input type="text" name="broadcast_text" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="image_first">Choose First Image (Required)</label>
            <input type="file" name="image_first" id="image_first" class="form-control" required>
            @error('image_first')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="image_second">Choose Second Image (Optional)</label>
            <input type="file" name="image_second" id="image_second" class="form-control">
            @error('image_second')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label>Point:</label>
            <input type="number" name="point" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Tanggal Mulai:</label>
            <input type="text" name="start_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Tanggal Selesai:</label>
            <input type="text" name="end_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('dashboard.events.index') }}" class="btn btn-secondary">Back</a>
    </form>
@endsection
