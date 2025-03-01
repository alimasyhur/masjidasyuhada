@extends('adminlte::page')

@section('title', 'Members')

@section('content_header')
    <h1>Members</h1>
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Identity</th>
                        <th>Email</th>
                        <th>Nama Lengkap</th>
                        <th>Whatsapp</th>
                        <th>Point Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($members as $member)
                        <tr>
                            <td>{{ $member->identity }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->fullname }}</td>
                            <td>{{ $member->wa_number }}</td>
                            <td>{{ $member->point_total }}</td>
                            <td>{{ ($member->is_checked === 1) ? 'Terverifikasi' : 'Belum Terverifikasi' }}</td>
                            <td>
                                <a href="{{ route('dashboard.members.show', $member) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('dashboard.members.edit', $member) }}" class="btn btn-warning btn-sm">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $members->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection

