@extends('layouts.app')

@section('title', config('app.name', 'Laravel').' - Vender')

@section('content')
<div class="container bg-white px-4 mt-4 py-4 border" 
style="width: 94%; max-width: 870px">
    <div class="row">

        <div class="col-md-12 boder">

            <h3>Publique o seu produto</h3>
            <hr>
            @include('includes.messages')

            <form action="{{ BASE_URL }}/vender" method="post">

            @csrf
            
            <div class="row">

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Nome</label>
                        <input type="text" name="name" id="name" 
                        placeholder="Nome" value="{{ old('name') }}" 
                        class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ 'O nome é necessário. Por favor preencha' }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Preço</label>
                        <input type="text" name="price" id="price" 
                        value="{{ old('price') }}" placeholder="Preço" 
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
                        value="{{ old('quantity') }}" placeholder="Quantidade" 
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
                            <option value=""  disabled>Selecione o estado...</option>
                            <option value="1" selected>Publicar</option>
                            <option value="2">Não Publicado</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Qualidade</label>
                        <select name="quality" id="quality" class="form-control">
                            <option value="" selected disabled>Selecione a qualidade...</option>
                            <option value="1">Novo</option>
                            <option value="2">Usado</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Categoria</label>
                        <select name="category_id" id="category_id" 
                        class="form-control  @error('category_id') is-invalid @enderror">
                            <option value="" selected disabled>Selecione a categoria...</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ 'Seleciona uma categoria Por favor.' }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Subcategoria</label>
                        <select name="subcategory_id" id="subcategory_id" 
                        class="form-control   @error('subcategory_id') is-invalid @enderror">
                            <option value="" selected disabled>Selecione a Subcategoria...</option>
                            
                        </select>
                        @error('subcategory_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ 'Seleciona uma subcategoria Por favor.' }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Código do Video</label>
                        <input placeholder="Coloque o código do vídeo" 
                        id="video_frame" name="video_frame" value="{{ old('video_frame') }}" 
                        class="form-control"/>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Província(Opcional)</label>
                        <select name="state_id" 
                        class="form-control" id="state">
                            <option value="">Selecione</option>
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
                            @if(isset($_GET['state']))

                            <?php foreach ($states as $state) : ?>
                            @if($_GET['state'] == $state->id)
                            @foreach($state->cities as $city)
                            <option value="{{ $city->id }}"
                                <?php echo ((isset($_GET['city'])) && $_GET['city'] == $city->id ) ? 'selected="selected"' : ''; ?>>
                                {{ $city->name }}</option>
                            @endforeach

                            @endif
                            <?php endforeach; ?>

                            @endif
                            <option value="">Selecione</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Descrição</label>
                        <textarea placeholder="Coloque uma descrição mais detalhada do produto" 
                        id="description" name="description" class="form-control">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="col-md-12">
                    <button class="btn btn-primary" type="submit">Registar</button>
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
            $.get('{{ BASE_URL }}/subcat?category_id=' + category_id, function(data){
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

    })
    
  </script>

@endsection
