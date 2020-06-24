@extends('layouts.admin')

@section('title', config('app.name', 'Laravel').' - Classificações')

@section('content')
<div class="container bg-white px-4 py-4 border">
    <div class="row">
        <div class="col-md-12">
            @if(Session::has('success'))
                <p class="alert alert-success">{{ Session::get('success') }}</p>
            @elseif(Session::has('warning'))
                <p class="alert alert-warning">{{ Session::get('warning') }}</p>
            @endif
            <div class="d-flex justify-content-between" style="align-items: center">
                <h5 style="text-transform: uppercase">Classificações</h5>    
                <?php 
                
                $ratings = App\models\RatingProduct::orderBy('id', 'DESC')
                ->with('user')
                ->with('product')
                ->paginate(10)->appends(request()->query()); 
                                           
                ?>         
            </div>
            
            
            
            @if(count($ratings))
            <table class="table table-striped 
            bg-white border table-responsive">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td style="width: 100px">Usuário</td>
                        <td>Produto</td>
                        <td>Mensagem</td>
                        <td>Estrelas</td>
                        <td>Data</td>
                        <td style="width: 230px">Acções</td>
                    </tr>
                </thead>
            <tbody>
            @foreach($ratings as $rate) 
            <tr>
                <td>{{ $rate->id }}</td>
                <td>
                    {{ ($rate->user->name ?? '') }}
                </td>
                <td>
                    {{ ($rate->product->name ?? '') }}
                </td>
                <td>{{ $rate->message }}</td>
                <td>{{ $rate->stars }}</td>
                <td>{{ $rate->created_at }}</td>
                <td>
                    <a href="{{ BASE_URL }}/admin/rating/delete/{{ $rate->id }}" 
                        class="btn btn-danger">Excluir</a>
                </td>
                
            </tr>
            
            @endforeach
            </tbody>
            </table>
            @else
            <hr>
            <h4>Sem classificações de momento.</h4>
            @endif

            <br>
            {{ $ratings->links() }}
        </div>
    </div>
</div>
@endsection
