@extends('adminlte::page')

@section('title', 'Relawan Detail')

@section('content_header')
    <h1>Relawan Detail</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>{{ $relawan->fullname }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Identity:</strong> {{ $relawan->identity }}</p>
            <p><strong>Email:</strong> {{ $relawan->email }}</p>
            <p><strong>Nama Lengkap:</strong> {{ $relawan->fullname }}</p>
            <p><strong>Whatsapp:</strong> {{ $relawan->wa_number }}</p>
            <p><strong>Alamat Lengkap:</strong> {{ $relawan->address }}</p>
            <p><strong>Frequency:</strong> {{ $relawan->frequency }}</p>
            <p><strong>Status:</strong> {{ ($relawan->is_checked === 1) ? 'Terverifikasi' : 'Belum Terverifikasi' }}</p>
            <p><strong>Tanggal Pengecekan:</strong> {{ $relawan->date_checked }}</p>
            <p><strong>Created At:</strong> {{ $relawan->created_at }}</p>
            <p><strong>Updated At:</strong> {{ $relawan->updated_at }}</p>

            <br>

            <a href="{{ route('dashboard.relawans.index') }}" class="btn btn-secondary">Back</a>
            <a href="{{ route('dashboard.relawans.edit', $relawan) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
@endsection
