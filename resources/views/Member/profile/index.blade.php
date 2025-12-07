@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-gold">Profil Akun</h1>
    <div class="card">
        <div class="card-header bg-dark text-gold">
            Informasi Akun
        </div>
        <div class="card-body">
            <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
            <p><strong>Tanggal Bergabung:</strong> {{ Auth::user()->created_at->format('d M Y') }}</p>
            <a href="{{ route('profile.edit') }}" class="btn btn-gold">Edit Profil</a>
        </div>
    </div>
</div>
@endsection
