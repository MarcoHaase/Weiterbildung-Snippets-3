@extends('layouts.layout')

@section('title', 'Kontaktformular')

{{-- Kommentar --}}

@section('content')
    <main class="py-4">
    <div class="container">
    <div class="row justify-content-center">
    <div class="col-6">
        @empty(session('data'))
        <div class="alert alert-primary" role="alert">
            <p>Bitte tragen Sie hier Ihre Nachricht ein!</p>
        </div>
        @else
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">{{ session('info') }}</h4>
            <p>Ihre Nachricht:</p>
            <p> {{ session('data')['msg'] }}</p>
        </div>
        @endempty
        <form method="post" action="/contact">
            @csrf
            <div class="form-group">
                <label for="username" class="col-12 col-form-label text-right">Username</label>
                @guest
                    <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" value="{{ old('username', '') }}">
                    @error('username') {{ $message }} @enderror
                @else
                    <input type="text" disabled class="form-control" name="username" id="username" value="{{ Auth::user()->name }}">
                @endguest
            </div>
            <div class="form-group">
                <label for="telefon" class="col-12 col-form-label text-right">Telefon</label>
                <input type="text" class="form-control @error('telefon') is-invalid @enderror" name="telefon" id="telefon" value="{{ old('telefon', '') }}">
                @error('telefon') {{ $message }} @enderror
            </div>
            <div class="form-group">
                <label for="msg" class="col-12 col-form-label text-right">Nachricht</label>
                <textarea type="text" class="form-control @error('msg') is-invalid @enderror" cols="30" rows="4" name="msg" id="msg">{{ old('msg', '') }}</textarea>
                @error('msg') {{ $message }} @enderror
            </div>
            <input type="submit" class="btn btn-primary" value="Abschicken">
            <input type="reset" class="btn btn-primary" value="Zurücksetzen">
        </form>
    </div>
    </div>
    </div>
    </main>
@endsection