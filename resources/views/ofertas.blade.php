@extends('layouts.app')

@section('title', config('app.name', 'Laravel').' - Página Inicial')

@section('content')

<div class="container-fluid mt-4" id="app">

    @if(Session::has('success'))
    <p class="mt-4  alert alert-success">{{ Session::get('success') }}</p>
    @elseif(Session::has('warning'))
    <p class="mt-4 alert alert-warning">{{ Session::get('warning') }}</p>
    @endif

    <div class="row">

        <div class="col-md-3">

            <div class="shadow-sm bg-white p-3 mb-3">


                <h5>FILTRAR PRODUTOS</h5>
                <hr>
                <form action="{{ BASE_URL }}/ofertas" method="get">

                    <div class="form-group">
                        <label for="">Palavras chaves</label>
                        <input class="form-control mr-sm-2" name="q" type="text" placeholder="O que procuras?"
                            value="{{ $_GET['q'] ?? '' }}">
                    </div>

                    <hr>
                    <div class="form-group">
                        <label>Província</label>
                        <select name="state" class="form-control" id="state">
                            <option value="">Selecione</option>
                            <?php foreach ($states as $state) : ?>
                            <option value="{{ $state->id }}"
                                <?php echo ((isset($_GET['state'])) && $_GET['state'] == $state->id ) ? 'selected="selected"' : ''; ?>>
                                {{ $state->name }}</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Cidade</label>
                        <select name="city" class="form-control" id="city">
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

                    <hr>

                    <div class="form-group">
                        <label>Categoria</label>
                        <select name="categoria" class="form-control" id="categoria">
                            <option value="">Selecione</option>
                            <?php foreach ($categories as $cat) : ?>
                            <option value="{{ $cat->id }}"
                                <?php echo ((isset($_GET['categoria'])) && $_GET['categoria'] == $cat->id ) ? 'selected="selected"' : ''; ?>>
                                {{ $cat->name }}</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>SubCategoria</label>
                        <select name="subcategoria" class="form-control" id="subcategoria">
                            @if(isset($_GET['categoria']))

                            <?php foreach ($categories as $cat) : ?>
                            @if($_GET['categoria'] == $cat->id)
                            @foreach($cat->subcategories as $sub)
                            <option value="{{ $sub->id }}"
                                <?php echo ((isset($_GET['subcategoria'])) && $_GET['subcategoria'] == $sub->id ) ? 'selected="selected"' : ''; ?>>
                                {{ $sub->name }}</option>
                            @endforeach

                            @endif
                            <?php endforeach; ?>

                            @endif
                            <option value="">Selecione</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Preço</label>
                        <select name="preco" class="form-control" id="preco">
                            <option value="" selected disabled>Selecione</option>
                            <option value="" selected disabled>Selecione</option>
                            <option value="1000-10000"
                                <?php echo ((isset($_GET['preco'])) && $_GET['preco'] == '1000-10000') ? 'selected="selected"' : ''; ?>>
                                1.000-10.000 mil</option>
                            <option value="10000-50000"
                                <?php echo ((isset($_GET['preco'])) && $_GET['preco'] == '10000-50000') ? 'selected="selected"' : ''; ?>>
                                10.000-50.000 mil</option>
                            <option value="100000-500000"
                                <?php echo ((isset($_GET['preco'])) && $_GET['preco'] == '100000-500000') ? 'selected="selected"' : ''; ?>>
                                100.000-500.000 mil</option>
                            <option value="500000-1000000"
                                <?php echo ((isset($_GET['preco'])) && $_GET['preco'] == '500000-1000000') ? 'selected="selected"' : ''; ?>>
                                500.000-1.000.000 milhão</option>
                            <option value="1000000-2000000"
                                <?php echo ((isset($_GET['preco'])) && $_GET['preco'] == '1000000-2000000') ? 'selected="selected"' : ''; ?>>
                                1.000.000-2.000.000 milhões</option>
                            <option value="2000000-5000000"
                                <?php echo ((isset($_GET['preco'])) && $_GET['preco'] == '2000000-5000000') ? 'selected="selected"' : ''; ?>>
                                2.000.000-5.000.000 milhões</option>
                            <option value="5000000-10000000"
                                <?php echo ((isset($_GET['preco'])) && $_GET['preco'] == '5000000-10000000') ? 'selected="selected"' : ''; ?>>
                                5.000.000-10.000.000 milhões</option>
                            <option value="10000000-15000000"
                                <?php echo ((isset($_GET['preco'])) && $_GET['preco'] == '10000000-15000000') ? 'selected="selected"' : ''; ?>>
                                10.000.000-15.000.000 milhões</option>
                            <option value="15000000-100000000"
                                <?php echo ((isset($_GET['preco'])) && $_GET['preco'] == '15000000-100000000') ? 'selected="selected"' : ''; ?>>
                                +15.000.000 milhões</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary form-control mb-4">
                        <i class="fa fa-search"></i>
                    </button>
                </form>

                @include('includes.categories')
            </div>

        </div>

        <div class="col-md-9 text-center">

            <div id="">

                @if(count(request()->all()) == 0)
                <h5 style="padding:8px; 
                text-align: center; background: #d6a607;" class="text-white ">PATROCINADOS</h5>
                <div class="row">

                    @foreach ($featureds as $product)
                    @include('includes.product')
                    @endforeach

                </div>
                @endif

                @if(count($products) == 0)
                <div class="alert alert-danger">A sua pesquisa não deu resultados</div>
                <div class="desktop" style="min-height: 300px;">
                    @include('includes.categories')
                </div>
                
                @else



                @if(request('categoria') || request('preco') 
                || request('subcategoria') || request('q')
                || request('state') || request('city')
                )
                <div class="alert alert-success">
                    Resultados da sua pesquisa...</div>
                @else
                
                <h5 style="padding:8px; 
                text-align: center; " class="text-white @if(!request()->has('page')) {{ 'mt-4' }} @endif 
                bg-yellow mb-3">ÚLTIMAS OFERTAS</h5>

                @endif

                <div class="row">

                    @foreach ($products as $product)
                    @include('includes.product')
                    @endforeach

                </div>
                <div style="width: 100%; overflow-x:auto">
                    {{ $products->links() }}
                </div>

                @endif

            </div>
        </div>


    </div>
</div>

<script>
    $(function() {
        //$('#example').append("Texto para aquele div");
        $('#categoria').change(function(e) {
            console.log(e);
            const category_id = e.target.value;
            // ajax
            $.get('{{ BASE_URL}}/subcat?category_id=' + category_id, function(data){
            //console.log(data);
            $('#subcategoria').empty();
            $.each(data, function(index, subCatObj) {
                $('#subcategoria').append('<option value="'+subCatObj.id+'">'+subCatObj.name+'</option>');
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