<?php 
use Illuminate\Support\Facades\Auth; 
?>

<div class="col-md-4 mb-3">

    <div class="card text-center" 
    <?php if($product->featured == 1): ?>
    style="border: 3px solid #dd9f0e;" 
    <?php endif; ?>>
        <div class="card-body" style="min-height: 200px;">
            <a style="ggggg: #dd9f0e" href="{{ BASE_URL }}/product/{{ $product->slug }}">
                @if(count($product->images) > 0)
                @foreach ($product->images as $image)
                <img class="card-img image-product" src="{{ BASE_URL }}/uploads/products/{{ $image->file }}"
                    alt="">
                @break
                @endforeach

                @else
                <img class="card-img image-product" src="{{ BASE_URL }}/images/default.png"
                alt="">
                @endif

            </a>

            <div style="height: 80px;" class="mt-2">
               <span>
                <a href="{{ BASE_URL }}/product/{{ $product->slug }}" class="product-title ">
                    {{ $product->name }}
                </a>
            </span> <br>
           
                <b class="price">
                    {{ currencyFormat($product->price) }}
                </b> 
            </div>
            
        </div>
        <div class="card-footer" style="min-height: 100px; 
        display: flex; 
        font-size: 14px; flex-direction: column;">
            

                <div class="mt-2">
                    <div class="">
                        Por <a
                            href="{{ BASE_URL }}/{{ $product->user->username }}">{{ $product->user->name }}</a> <br>
                        <b>Telefone:</b> {{ $product->user->phone ?? 'Sem telefone' }}
                    </div>
                    @if(Auth::check())
                    @if(Auth::user()->id == $product->user_id)
                    <div class="">

                        <a href="#" data-toggle="modal" data-target="#deleteModal{{ $product->id }}">Excluir</a>
                        <a href="{{ BASE_URL }}/product/edit/{{ $product->id }}">Editar</a>

                        <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Excluir Produto</h5>
                                    </div>
                                    <div class="modal-body">
                                        Tens a certeza que desejas deletar o producto: {{ $product->name }}??
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Fechar</button>
                                        <a href="{{ BASE_URL }}/product/delete/{{$product->id}}"
                                            class="btn btn-danger"> <i class="fa fa-trash"></i> Excluir</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    @endif
                    @endif
                </div>
        </div>
    </div>

</div>