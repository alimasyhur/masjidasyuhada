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
        <div class="col-12">
            <div class="card card-primary card-outline mb-4">
                <div class="card-header"><div class="card-title">Ramadhan Fest Squad</div></div>
                <div class="card-body">
                    <h3>Daftar Ramadhan Fest Squad</h3>
                    <p>Dengan mendaftar member, Anda akan mendapatkan reward koin selama mengikuti kegiatan Ramadhan di Masjid Sejuta Pemuda</p>
                    <a href="{{ route('public.members.register') }}" class="btn btn-primary mb-2">Daftar</a>
                </div>
            </div>
        </div>
    </div>

@endsection
