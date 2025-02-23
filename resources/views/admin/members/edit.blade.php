@extends('adminlte::page')

@section('title', 'Edit Member')

@section('content_header')
    <h1>Edit Member</h1>
@endsection

@section('content')
    <form action="{{ route('dashboard.members.update', $member) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Email:</label>
            <input type="text" name="email" class="form-control" value="{{ $member->email }}" required>
        </div>

        <div class="form-group">
            <label>Fullname:</label>
            <input type="text" name="fullname" class="form-control" value="{{ $member->fullname }}" required>
        </div>

        <div class="form-group">
            <label>Whatsapp:</label>
            <input type="text" name="wa_number" class="form-control" value="{{ $member->wa_number }}" required>
        </div>

        <div class="form-group">
            <label>Address:</label>
            <textarea name="address" class="form-control" required>{{ $member->address }}</textarea>
        </div>

        <div class="form-group">
            <label>Status Cek</label>
            <!-- <input type="integer" name="is_checked" class="form-control" value="{{ $member->is_checked }}" required> -->
            <select class="form-control select2" id="is_checked" style="width: 100%;" name="is_checked">
                <option value="0" {{ old('is_checked', $member->is_checked) == 0 ? 'selected' : '' }}>Belum Terverifikasi</option>
                <option value="1" {{ old('is_checked', $member->is_checked) == 1 ? 'selected' : '' }}>Terverifikasi</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('dashboard.members.index') }}" class="btn btn-secondary">Back</a>
    </form>
@endsection
