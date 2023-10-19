@extends('adminlte::page')

@section('title', 'recomendaciones')

@section('content_header')
    <h1>LISTA DE VENTAS</h1>
@stop

@section('content')
    @livewire('recomendacion.tienda-similar.tienda-similar-index', ['pdv_id' => $pdv_id])
@stop

@section('css')
    @livewireStyles
@stop

@section('js')
    @livewireScripts
@stop
