@extends('layouts.admin')

@section('title', config('app.name', 'Laravel').' - Pedidos de promoção.')

@section('content')
<div class="container bg-white px-4 py-4 border">
    <h2>Pedidos de Promoção</h2>
    @include('includes.messages')
    @if(count($pedidos))

    <table class="table table-stripped table-responsive-sm">
        <thead>
            <td>ID</td>
            <td>Usuário</td>
            <td>Produto</td>
            <td>Estado</td>
            <td>Acções</td>
        </thead>
        <tbody>
            @foreach($pedidos as $key => $pedido)
            <tr>
                <td>{{ $pedido->id }}</td>
                <td>{{ $pedido->user->name }}</td>
                <td>{{ $pedido->product->name }}</td>
                <td>
                    <?php $link = "<a 
                    data-toggle='modal' data-target='#adsModal$pedido->id'
                    class='btn-danger btn'>Pendente -> Confirmar</a>"; ?>
                    <?php $link2 = "<a class='btn-success btn' href=".BASE_URL."/admin/ads/active/$pedido->id>Confirmado</a>"; ?>
                    {!! ($pedido->status == 1) ? $link2 : $link !!}
                </td>
                <td>
                    <a class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $pedido->id }}">
                        <i class="fa fa-trash"></i> </a>
                    <a class="btn btn-primary" href="{{ BASE_URL }}/ads/edit/{{ $pedido->id }}">
                        <i class="fa fa-edit"></i> </a>

                        <div class="modal fade" id="adsModal{{ $pedido->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
    
                                        <h5 class="modal-title" id="exampleModalLongTitle">Ativar Pedido de Promoção</h5>
    
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ BASE_URL }}/admin/ads/active/{{ $pedido->id }}" 
                                            method="post">
                                            @csrf
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="valor">Valor</label>
                                                        <input type="text" value="0.00" name="valor" id="" class="form-control">
                                                    </div>                                                    
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="inicio">Data de Término</label>
                                                        <input type="date" required min=
                                                        <?php
                                                            echo date('Y-m-d');
                                                        ?> name="end" id="" class="form-control">
                                                    </div>                                                    
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="" style="color: #fff; display: block">...</label>
                                                        <button class="btn btn-primary">
                                                            Promover
                                                        </button>
                                                    </div>
                                                    
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <a href="{{ BASE_URL }}/admin/ads/delete/{{$pedido->id}}" class="btn btn-danger"> <i
                                                class="fa fa-trash"></i> Excluir</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <div class="modal fade" id="deleteModal{{ $pedido->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <h5 class="modal-title" id="exampleModalLongTitle">Excluir cidade</h5>

                                </div>
                                <div class="modal-body">
                                    Tens a certeza que desejas deletar o pedido nº: {{ $pedido->id }}??
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <a href="{{ BASE_URL }}/admin/ads/delete/{{$pedido->id}}" class="btn btn-danger"> <i
                                            class="fa fa-trash"></i> Excluir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

</div>
@endsection