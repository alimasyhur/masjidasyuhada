@extends('adminlte::page')

@section('title', 'Relawans')

@section('content_header')
    <h1>Relawans</h1>
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
                        <th>Frequency</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($relawans as $relawan)
                        <tr>
                            <td>{{ $relawan->identity }}</td>
                            <td>{{ $relawan->email }}</td>
                            <td>{{ $relawan->fullname }}</td>
                            <td>{{ $relawan->wa_number }}</td>
                            <td>{{ $relawan->frequency }}</td>
                            <td>{{ ($relawan->is_checked === 1) ? 'Terverifikasi' : 'Belum Terverifikasi' }}</td>
                            <td>
                                <a href="{{ route('dashboard.relawans.show', $relawan) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('dashboard.relawans.edit', $relawan) }}" class="btn btn-warning btn-sm">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $relawans->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection

