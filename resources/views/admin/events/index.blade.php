@extends('adminlte::page')

@section('title', 'Events')

@section('content_header')
    <h1>Events</h1>
@endsection

@section('content')
    <a href="{{ route('dashboard.events.create') }}" class="btn btn-primary">Add Event</a>
    <br><br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Broadcast Text</th>
                <th>Point</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $event)
                <tr>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->broadcast_text }}</td>
                    <td>{{ $event->point }}</td>
                    <td>
                        <a href="{{ route('dashboard.events.show', $event) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('dashboard.events.edit', $event) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('dashboard.events.destroy', $event) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this event?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
    {{ $events->links('pagination::bootstrap-4') }}
</div>
@endsection
