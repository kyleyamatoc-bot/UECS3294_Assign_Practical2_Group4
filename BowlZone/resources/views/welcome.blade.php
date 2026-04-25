@extends('layouts.app')

@section('title', 'BowlZone')

@section('content')
<div class="card">
    <h1 class="section-title">BowlZone</h1>
    <p>This project now uses custom MVC pages. Go to Home to continue.</p>
    <a class="btn" href="{{ route('home') }}">Go Home</a>
</div>
@endsection