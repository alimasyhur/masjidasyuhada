@extends('layouts.public')

@section('title', 'Login Berhasil')

@section('header')
    Login Berhasil
@endsection

@section('content')
    <div class="row">
        <div class="card card-primary card-outline">
            <div class="card-header"><h3 class="card-title">Data DIri</h3></div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <b>Tunjukkan nomor Identitas MSP Anda setiap kali mengikuti kegiatan Ramadhan Fest</b>
                <p>Nomor Identitas MSP Anda: <h4>{{ $relawan->identity }}</h4></p>
                <p>Email: {{ $relawan->email }}</p>
                <p>Nama Lengkap: {{ $relawan->fullname }}</p>
                <p>Nomor Whatsapp: {{ $relawan->wa_number }}</p>
                <p>Alamat Lengkap: {{ $relawan->address }}</p>
                <p>Frequency: {{ $relawan->frequency }}</p>

                <a href="{{ route('public.members.logout') }}" class="btn btn-danger">Logout</a>
                <a href="{{ route('event') }}" class="btn btn-secondary">Back</a>

            </div>
            </div>
        </div>
    </div>



@endsection
