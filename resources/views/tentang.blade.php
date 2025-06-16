@extends('layouts.app')

@section('title', 'Tentang - Speed Solution')

@section('content')
{{-- Vue.js Mount Point --}}
<div id="app">
    <tentang-content></tentang-content>
</div>

@include('partials.partners')
@include('partials.footer')

@endsection