@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-gold">Edit Profil</h1>
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name" class="text-gold">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ Auth::user()->name }}">
        </div>
        <div class="form-group">
            <label for="email" class="text-gold">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ Auth::user()->email }}">
        </div>
        <button type="submit" class="btn btn-gold">Simpan Perubahan</button>
    </form>
</div>
@endsection
