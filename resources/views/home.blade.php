@extends('adminlte::page')

@section('title', 'Data Peaks')

@section('content_header')
@stop

@section('content')
    @livewire('dashboard.top-ventas')
    <hr>
    @livewire('dashboard.cant-ventas')
@stop

@section('css')
    @livewireStyles
@stop

@section('js')
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@stop
