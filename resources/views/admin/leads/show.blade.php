@extends('layouts.admin')

@section('content')
  <div class="container mt-4">
    <h1>Messaggio del contatto</h1>
    <dl>
      <dt>Nome e cognome</dt>
      <dd>{{ $lead->name }} {{ $lead->lastname }}</dd>
      <dt>email</dt>
      <dd>{{ $lead->email }}</dd>
      <dt>telefono</dt>
      <dd>{{ $lead->phone_number }}</dd>
      <dt>Messaggio</dt>
      <dd>{{ $lead->message }}</dd>

    </dl>
  </div>
@endsection