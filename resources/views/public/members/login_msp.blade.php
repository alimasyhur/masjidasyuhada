@extends('layouts.public')

@section('title', 'Login')

@section('header')
    Login MSP
@endsection

@section('content')
    <div class="row">
        <h1>Login</h1>
    </div>


    <div class="row">
        <div class="col-6">
            <div class="card card-primary card-outline mb-4">
                <div class="card-header"><div class="card-title">Member</div></div>
                <div class="card-body">
                    <h3>Login Member</h3>
                    <a href="{{ route('public.members.login') }}" class="btn btn-success mb-2">Login</a>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card card-primary card-outline mb-4">
                <div class="card-header"><div class="card-title">Relawan</div></div>
                <div class="card-body">
                    <h3>Login Relawan</h3>
                    <a href="{{ route('public.relawans.login') }}" class="btn btn-success mb-2">Login</a>
                </div>
            </div>
        </div>
    </div>

@endsection
