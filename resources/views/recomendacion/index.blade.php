@extends('adminlte::page')

@section('title', 'recomendaciones')

@section('content_header')
  <h1>LISTA DE VENTAS</h1>
@stop

@section('content')
  @livewire('recomendacion.index')
@stop

@section('css')
@livewireStyles
@stop

@section('js')
@livewireScripts
@stop