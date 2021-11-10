@extends('layouts.layout')

@section('title', 'Messages')

{{-- Kommentar --}}

@section('content')
<main class="py-4">
<div class="container">
<div class="row justify-content-center">
@isset($message)
<div class="col-8">
    <div class="d-flex justify-content-center">
        <a href="/admin">Zurück zur Übersicht</a>
    </div>
<table class="table table-bordered mb-5">
    <tr><th scope="col">Message-ID</th><td>{{ $message['id']}}</td></tr>
    <tr><th scope="col">User-ID</th><td>{{ (isset($message['userid']) ? $message['userid'] : "Guest") }}</td></tr>
    <tr><th scope="col">Username</th><td>{{ $message['username']}}</td></tr>
    <tr><th scope="col">Telefon</th><td>{{ $message['telefon']}}</td></tr>
    <tr><th scope="col">Nachricht</th><td>{{ $message['msg'] }}</td></tr>
    <tr><th scope="col">Bearbeitungsstatus</th><td>{{ status2string($message['status']) }}</td></tr>
</table>
    <form action="/admin/{{ $message['id'] }}" method="post">
        @csrf
        <label for="comment" class="col-12 col-form-label text-right">Neuer Kommentar</label>
        <div class="form-group">
            <textarea class="form-control @error('comment') is-invalid @enderror" name="comment" id="comment" cols="70" rows="6">{{ old('comment', '') }}</textarea>
            @error('comment') {{ $message }} @enderror
        </div>
        <div class="form-group">
            <label for="status" class="col-12 col-form-label text-right">Status</label>
            <select class="form-control @error('status') is-invalid @enderror" name="status" id="status">
                <option disabled selected>---</option>
                {!! optionStatusList(old('status', $message['status'])) !!}
            </select>
            @error('status') {{ $message }} @enderror
        </div>
        <input type="submit" class="btn btn-primary" name="speichern" id="speichern" value="Speichern">
    </form>

    @isset($message['comments'])
        @foreach($message['comments'] as $m)            
        <table class="table table-bordered mb-5">
        <tr><th scope="col">Kommentar</th><td>{{ $m['comment'] }}</td></tr>
        <tr><th scope="col">User-ID</th><td>{{ $m['userid'] }}</td></tr>
        <tr><th scope="col">Username</th><td>{{ $m['username'] }}</td></tr>
        <tr><th scope="col">Erstellt</th><td>{{ $m['c_created_at'] }}</td></tr>
        <tr><th scope="col">Status</th><td>{{ status2string($m['status_set']) }}</td></tr>
        </table>
        @endforeach
    @endisset

</div>
</div>
@else
{{-- Pagination --}}
<div class="d-flex justify-content-center">{{  $data->links()  }}</div>
<table class="table table-bordered mb-5">

<thead>
    <tr class="table-success">
        <th scope="col">#</th>
        <th scope="col">Username</th>
        <th scope="col">Telefon</th>
        <th scope="col">Nachricht</th>
        <th scope="col">Status</th>
    </tr>
</thead>

<tbody>
@foreach ($data as $message)
    <tr>
        <th scope="row">{{ $message->id }}</th>
        <td><a href="/admin/{{ $message->id }}">{{ $message->username }}</a></td>
        <td>{{ $message->telefon }}</td>
        {{-- <td>{{ substr($message->msg, 0 , 15) . (strlen($message->msg) > 15 ? "..." : "") }}</td> --}}
        {{-- <td>{{ mb_strimwidth($message->msg, 0, 15, "...") }}</td> --}}
        <td>{{ Str::limit($message->msg, 15, '...') }}</td>
        <td>{{ status2string($message->status) }}</td>
    </tr>
@endforeach
</tbody>

</table>
<div class="d-flex justify-content-center">
    Eintrag ({{ $data->firstItem() }} - {{ $data->lastItem() }}) von {{ $data->total() }}</p>
</div>
@endisset
</div>
</div>
</main>
@endsection

