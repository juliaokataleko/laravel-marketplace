@extends('layouts.admin')

@section('title', config('app.name', 'Laravel').' - Editar O produto '. $product->name)

@section('content')
<style>
    .col-md-3 {
        margin-bottom: 10px;
    }
    
    .col-md-3 img {
        width: 100%;
    }

</style>
<div class="container bg-white px-4 py-4 border" style="width: 94%;">
    <div class="row">

        <div class="col-md-12 boder">

            <h3 class="text-danger">Editar O Produto: {{ $product->name }} </h3>
            <hr>
            @if(Session::has('success'))
                <p class="mt-4  alert alert-success">{{ Session::get('success') }}</p>
            @elseif(Session::has('warning'))
                <p class="mt-4 alert alert-warning">{{ Session::get('warning') }}</p>
            @endif

            <form enctype="multipart/form-data" action="{{ BASE_URL }}/admin/product/update/{{ $product->id }}" method="post">

            @csrf
            
            <div class="row">

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Nome</label>
                        <input type="text" name="name" id="name" 
                        placeholder="Nome" value="{{ $product->name }}" 
                        class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ 'O preço é necessário. Por favor preencha' }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Preço</label>
                        <input type="text" name="price" id="price" 
                        value="{{ $product->price }}" placeholder="Preço" 
                        class="form-control @error('price') is-invalid @enderror">
                        @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ 'O preço é necessário. Por favor preencha' }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="quantity">Quantidade</label>
                        <input type="text" name="quantity" id="quantity" 
                        value="{{ $product->quantity }}" placeholder="Quantidade" 
                        class="form-control @error('quantity') is-invalid @enderror">
                        @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ 'A quantidade não deve ficar em branco. 
                                    Coloque zero se nãop quiser preencher' }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Estado</label>
                        <select name="status" id="status" class="form-control">
                            <option value="" selected disabled>Selecione o estado...</option>
                            <option value="1" {{ ($product->status == 1) ? 'selected' : '' }}>Publicado</option>
                            <option value="2" {{ ($product->status == 2) ? 'selected' : '' }}>Não Publicado</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="featured">Em destaque?</label>
                        <select name="featured" id="featured" class="form-control">
                            <option value="0" {{ ($product->featured == 0) ? 'selected' : '' }}>Não</option>
                            <option value="1" {{ ($product->featured == 1) ? 'selected' : '' }}>Sim</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Qualidade</label>
                        <select name="quality" id="quality" class="form-control">
                            <option value="" selected disabled>Selecione a qualidade...</option>
                            <option value="1" {{ ($product->quality == 1) ? 'selected' : '' }}>Novo</option>
                            <option value="2" {{ ($product->quality == 2) ? 'selected' : '' }}>Usado</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Categoria</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="" selected disabled>Selecione a categoria...</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ ($product->category_id == $cat->id) ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Subcategoria</label>
                        <select name="subcategory_id" id="subcategory_id" class="form-control">
                            <option value="{{ $product->subcategory_id }}">{{ $subCatName }}</option>                            
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Código do Video</label>
                        <input placeholder="Coloque o código do vídeo" 
                        id="video_frame" name="video_frame" 
                        value="{{ $product->video_frame }}"
                        class="form-control"/>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Província(Opcional)</label>
                        <select name="state_id" 
                        class="form-control" id="state">
                        <option value="{{ $product->state_id }}">{{ $product->state->name ?? 'Selecione uma província' }}</option>
                            <?php foreach ($states as $state) : ?>
                            <option value="{{ $state->id }}"
                                <?php echo ((isset($_GET['state'])) && $_GET['categoria'] == $cat->id ) ? 'selected="selected"' : ''; ?>>
                                {{ $state->name }}</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">

                    <div class="form-group">
                        <label>Cidade(Opcional)</label>
                        <select name="city_id" class="form-control" id="city">
                            <option value="{{ $product->city_id }}">{{ $product->city->name ?? 'Selecione uma província e uma cidade' }}</option>
                        </select>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Descrição</label>
                        <textarea placeholder="Coloque uma descrição mais detalhada do produto" id="description" name="description" class="form-control">{{ $product->description }}</textarea>
                    </div>
                </div>

                <div class="col-md-12">
                    <h3 class="text-danger">Desconto</h3>
                    <div class="p-4 border ">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">Desconto</label>
                                <input type="text" name="discount" id="discount" 
                                value="{{ $discount->discount }}" placeholder="Preço" 
                                class="form-control @error('price') is-invalid @enderror">
                            </div>
                            <div class="col-md-4">
                                <label for="">Data Limite</label>
                                <input type="date" name="date_finish" id="date_finish" 
                                value="{{ date('Y-m-d', strtotime($discount->date_finish)) }}" placeholder="Data Limite" 
                                class="form-control @error('date_finish') is-invalid @enderror">
                            </div>
                            <div class="col-md-4">
                                <label for="">Estado</label>
                                <select name="status_discount" id="status_discount" class="form-control">
                                    <option value="">Selecione o estado...</option>
                                    <option value="1" {{ ($discount->status == 1) ? 'selected' : '' }}>Ativo</option>
                                    <option value="2" {{ ($discount->status == 2) ? 'selected' : '' }}>Não Ativo</option>
                                </select>                            
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <h3 class="text-danger my-4">Adicionar Fotos</h3> 
                        <input type="file" class="form-control mb-2" name="fotos[]" 
                        multiple id="fotos">
                        <div class="card">
                            <div class="card-header">
                                Fotos do Anúncio
                            </div>
                            <div class="card-body">
                                <div class="row">
                                <?php foreach($product->images as $image): ?>
                                    <div class="col-md-3 border p-4 text-center">
                                        <img class="img_thumbnail" border="0" 
                                        src="{{ BASE_URL }}/uploads/products/<?=$image->file;?>" alt="">
                                        <br><a href="{{ BASE_URL }}/admin/product/deleteimage/{{ $image->id }}" 
                                        class="btn btn-outline-danger mt-2">Excluir Imagem</a>
                                    </div>
                                <?php endforeach;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <button class="btn btn-primary" type="submit">Actualizar Producto</button>
                </div>

            </div>

            </form>

        </div>
    </div>
</div>


<script>
    $(function() {
        //$('#example').append("Texto para aquele div");
        $('#category_id').change(function(e) {
            console.log(e);
            const category_id = e.target.value;
            // ajax
            $.get('{{ BASE_URL }}/admin/subcat?category_id=' + category_id, function(data){
            //console.log(data);
            $('#subcategory_id').empty();
            $.each(data, function(index, subCatObj) {
                $('#subcategory_id').append('<option value="'+subCatObj.id+'">'+subCatObj.name+'</option>');
            });
            });
        });

        $('#state').change(function(e) {
            console.log(e);
            const state_id = e.target.value;
            // ajax
            $.get('{{ BASE_URL}}/city?state_id=' + state_id, function(data){
            //console.log(data);
            $('#city').empty();
            $.each(data, function(index, cityObj) {
                $('#city').append('<option value="'+cityObj.id+'">'+cityObj.name+'</option>');
            });
            });
        });

    });
    
  </script>

@endsection
