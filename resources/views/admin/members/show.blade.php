@extends('adminlte::page')

@section('title', 'Member Detail')

@section('content_header')
    <h1>Member Detail</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>{{ $member->fullname }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Identity:</strong> {{ $member->identity }}</p>
            <p><strong>Email:</strong> {{ $member->email }}</p>
            <p><strong>Nama Lengkap:</strong> {{ $member->fullname }}</p>
            <p><strong>Whatsapp:</strong> {{ $member->wa_number }}</p>
            <p><strong>Alamat Lengkap:</strong> {{ $member->address }}</p>
            <p><strong>Point Total:</strong> {{ $member->point_total }}</p>
            <p><strong>Status:</strong> {{ ($member->is_checked === 1) ? 'Terverifikasi' : 'Belum Terverifikasi' }}</p>
            <p><strong>Tanggal Pengecekan:</strong> {{ $member->date_checked }}</p>
            <p><strong>Created At:</strong> {{ $member->created_at }}</p>
            <p><strong>Updated At:</strong> {{ $member->updated_at }}</p>

            <br>

            <a href="{{ route('dashboard.members.index') }}" class="btn btn-secondary">Back</a>
            <a href="{{ route('dashboard.members.edit', $member) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
@endsection
