@extends('layouts.admin')

@section('title', 'Configurações - ' . config('app.name', 'Laravel'))

@section('content')

<style>
    .col-md-4 i, .col-md-12 i {
        font-size: 40px;
        color: #e67e22
    }
</style>

<div class="container bg-white px-4 py-4">
    <h2>CONFIGURAÇÕES</h2>
    <a href="{{ BASE_URL }}/admin">Painel</a>

    @if(Session::has('success'))
        <p class="mt-4  alert alert-success">{{ Session::get('success') }}</p>
    @elseif(Session::has('warning'))
        <p class="mt-4 alert alert-warning">{{ Session::get('warning') }}</p>
    @endif

    <form action="{{ BASE_URL }}/admin/config" method="post">
        @csrf
        <div class="row mt-4">

            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" 
                    placeholder="Nome do Loja"
                    class="form-control"
                    value="{{ $config->name }}"
                    name="name" id="name">
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" 
                    placeholder="Slogan Da Loja"
                    class="form-control"
                    value="{{ $config->slogan }}"
                    name="slogan" id="slogan">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <input type="url" 
                    class="form-control"
                    placeholder="URL da Loja"
                    value="{{ $config->url }}"
                    name="url" id="url">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <select name="num_pages" id="num_pages" 
                    class="form-control">
                        <option {{ ($config->num_pages == 10) ? 'selected' : '' }} value="10">10</option>
                        <option value="20"{{ ($config->num_pages == 20) ? 'selected' : '' }}>20</option>
                        <option value="50" {{ ($config->num_pages == 50) ? 'selected' : '' }}>50</option>
                        <option value="100" {{ ($config->num_pages == 100) ? 'selected' : '' }}>100</option>
                    </select>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <textarea
                    class="form-control"
                    name="about" id="about" 
                    placeholder="Sobre A Loja">{{ $config->about }}</textarea>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <textarea
                    class="form-control"
                    name="privacy_policy" id="privacy_policy" 
                    placeholder="Política de Privacidade">{{ $config->privacy_policy }}</textarea>
                </div>
            </div>

            <div class="col-md-12">
                <button class="btn btn-primary" >Salvar</button>
            </div>

        </div>

    </form>

</div>
@endsection
