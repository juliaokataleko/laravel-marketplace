@extends('layouts.app')

@section('title', config('app.name', 'Laravel').' - Categorias')

@section('content')

<div class="container bg-white px-4 py-4 border">
    <h2>Pedidos de Promoção</h2>
    @include('includes.messages')
    @if(count($pedidos))

    <table class="table table-stripped  table-responsive-sm">
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
                    <?php $link = "<a class='btn-danger btn'>Pendente</a>"; ?>
                    <?php $link2 = "<a class='btn-success btn'>Confirmado</a>"; ?>
                    {!! ($pedido->status == 1) ? $link2 : $link !!}
                </td>
                <td>
                    <a class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $pedido->id }}">
                        <i class="fa fa-trash"></i> </a>

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
                                    <a href="{{ BASE_URL }}/ads/delete/{{$pedido->id}}" class="btn btn-danger"> <i
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