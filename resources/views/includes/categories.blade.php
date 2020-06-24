<div class="bg-white my-3 border">
    <div class="card-header ">
        Categorias        
    </div>
    <div class="bg-white p-3">
        @foreach ($categories as $cat)
            <a class="btn btn-secondary mr-2 mb-2" style="display: inline-block" 
            href="{{ BASE_URL }}/category/{{ $cat->slug }}">
                 {{ $cat->name }} </a>
                 @foreach($cat->subcategories as $sub)
                    <a class="btn btn-primary mr-2 mb-2" style="display: inline-block"  
                    href="{{ BASE_URL }}/subcategory/{{ $sub->slug }}"> 
                    {{ $sub->name }}</a>
                @endforeach
            @endforeach
    </div>                
</div>