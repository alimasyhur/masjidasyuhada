@extends('layouts.public')

@section('title', 'Pendaftaran')

@section('header')
    Registrasi Relawan
@endsection

@section('content')
    <div class="row">
        <h1>Registrasi Relawan</h1>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline mb-4">
                <div class="card-header"><div class="card-title">Registrasi Relawan</div></div>
                    <div class="card-body">

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('public.relawans.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="fullname" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Nomor Whatsapp</label>
                            <input type="text" name="wa_number" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Alamat Domisili</label>
                            <textarea name="address" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Frekuensi kesanggupan membantu kegiatan dalam se-pekan</label>
                            <input type="number" name="frequency" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success">Save</button>
                        <a href="{{ route('public.members.index') }}" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
