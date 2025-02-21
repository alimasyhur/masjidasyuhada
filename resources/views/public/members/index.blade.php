@extends('layouts.public')

@section('title', 'Pendaftaran')

@section('header')
    Event
@endsection

@section('content')
    <div class="row">
        <h1>Pendaftaran</h1>
    </div>


    <div class="row">
        <div class="col-6">
            <div class="card card-primary card-outline mb-4">
                <div class="card-header"><div class="card-title">Member</div></div>
                <div class="card-body">
                    <h3>Daftar Member</h3>
                    <p>Dengan mendaftar member, Anda akan mendapatkan reward koin selama mengikuti kegiatan Ramadhan di Masjid Sejuta Pemuda</p>
                    <a href="{{ route('public.members.register') }}" class="btn btn-primary mb-2">Daftar</a>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card card-primary card-outline mb-4">
                <div class="card-header"><div class="card-title">Relawan</div></div>
                <div class="card-body">
                <h3>Daftar Relawan</h3>
                <p>Dengan mendaftar relawan, Anda akan mendapatkan reward koin selama menjadi relawan dan mengikuti kegiatan Ramadhan di Masjid Sejuta Pemuda</p>
                    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="toast" data-bs-target="toastDefault">
                        Daftar
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection
