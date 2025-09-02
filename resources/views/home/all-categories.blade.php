@extends('layouts.base')

@section('styles')
<link href="{{ asset('css/manage_post/categories/css/article_category.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title','')

@section('content')

@include('layouts.navbar')

<div class="text-primary">
    <h2>TODAS LAS CATEGORIAS</h2>
</div>

<div class="article-container">
    <!-- Listar categorías -->
    @foreach ($categories as $category)
    <article class="article category">
        {{-- <img src="{{ asset('storage/'.$category->image)}}" class="img"> --}}
        <img src="{{ $category->image }}" class="img">
        <div class="card-body">
            <a href="{{ route('categories.detail', $category->slug) }}" class="text-decoration-none">
                <h2 class="title category fs-4">{{ $category->name }}</h2>
            </a>
        </div>
    </article>
    @endforeach
</div>

<div class="links-paginate">    
    {{ $categories->links() }}
</div>
@endsection