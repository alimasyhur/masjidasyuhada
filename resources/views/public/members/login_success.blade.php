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
                <p>Nomor Identitas MSP Anda: <h4>{{ $member->identity }}</h4></p>
                <p>Email: {{ $member->email }}</p>
                <p>Nama Lengkap: {{ $member->fullname }}</p>
                <p>Nomor Whatsapp: {{ $member->wa_number }}</p>
                <p>Alamat Lengkap: {{ $member->address }}</p>

                <h3>Event yang Saya daftar:</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Event</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($myEvent as $event)
                        <tr>
                            <td>{{ $event->title }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                </table>

                <a href="{{ route('public.members.logout') }}" class="btn btn-danger">Logout</a>
                <a href="{{ route('event') }}" class="btn btn-secondary">Back</a>

            </div>
            </div>
        </div>
    </div>



@endsection
