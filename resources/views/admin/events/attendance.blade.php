@extends('adminlte::page')

@section('title', 'Attendance Event')

@section('content_header')
    <h1>Attendance Event</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>{{ $event->title }} ({{ $event->point }} point)</h4>
        </div>
        <div class="card-body">
            <p><strong>Waktu Event: </strong> {{ $event->start_date }} - {{ $event->end_date }}</p>

            <form action="{{ route('dashboard.members.storeAttendance') }}" method="POST">
                @csrf

                @if(session('error'))
                    <div class="alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif

                <input type="hidden" name="event_id" value="{{ $event->id }}">

                <div class="form-group">
                    <label>No. Identity:</label>
                    <div class="row">
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="fixedPart" value="MRF-MSP-" disabled>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="identity" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success">Save</button>
                            <a href="{{ route('dashboard.events.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Member Attendances ({{ $totalAttendance }})</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Identity</th>
                        <th>Fullname</th>
                        <th>Email</th>
                        <th>Whatsapp</th>
                        <th>Attendance At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendanceMembers as $attendance)
                        <tr>
                            <td>{{ $attendance->identity }}</td>
                            <td>{{ $attendance->fullname }}</td>
                            <td>{{ $attendance->email }}</td>
                            <td>{{ $attendance->wa_number }}</td>
                            <td>{{ $attendance->date_attendance }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
