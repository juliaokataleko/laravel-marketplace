@extends('layouts.app')

@section('title', config('app.name', 'Laravel').' - Página Inicial')

@section('content')
<br><br>
<div class="container mt-4 bg-white border" id="app" style="margin-top: 6em; padding: 23px">

    @if(Session::has('success'))
        <p class="mt-4  alert alert-success">{{ Session::get('success') }}</p>
    @elseif(Session::has('warning'))
        <p class="mt-4 alert alert-warning">{{ Session::get('warning') }}</p>
    @endif
    <h2>Termos e condições</h2>
    <div class="row ">

        <div class="col-sm-3">
            <p>Logo</p>
        </div>
        <div class="col-sm-9">
            <p>Descrição...</p>
        </div>
    </div>

</div>