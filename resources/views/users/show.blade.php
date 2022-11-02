@extends('layout')

@section('title', "Usuario #{$id}")

@section('content')
    <h1>Usuario #{{ $id }}</h1>

    <p>Mostrando los detalles del usuario #{{ $id }}</p>
@endsection

@section('sidebar')
    <h2>Barra lateral personaliza</h2>
@endsection