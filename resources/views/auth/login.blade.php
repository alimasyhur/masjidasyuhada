@extends('adminlte::auth.login')

@section('auth_body')
    <p class="text-center">Selamat datang! Silakan login untuk melanjutkan.</p>

    <form action="{{ route('login') }}" method="POST">
        @csrf

        {{-- Email Input --}}
        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        {{-- Password Input --}}
        <div class="mb-3">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        {{-- Custom Remember Me Checkbox --}}
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="remember" id="remember">
            <label class="form-check-label" for="remember">Ingat saya</label>
        </div>

        {{-- Login Button --}}
        <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>
@endsection

@section('auth_footer')
    {{-- Hapus link register --}}
@endsection
