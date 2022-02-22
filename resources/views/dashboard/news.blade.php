@extends('layouts.dashboard')
@section('title', 'Recent News')

@section('content')
<div class="container">
    <div class="row pt-4 pt-lg-5">
        <div class="col">
            <h1>Recent News</h1>
        </div>
    </div>

    <div class="row news">
        @foreach($news as $article)
            <div class="col-md-4 article-column">
                <a href="{{ $article['url'] }}" class="card article" target="_blank">
                    <div class="image" style="background-image: url({{ $article['image'] }})"></div>
                    <div class="card-body">
                        <h5></h5>
                        <h4>{{ $article['headline'] }}</h4>
                        <div class="summary">{{ \Illuminate\Support\Str::limit($article['summary'], 150, '...') }}</div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
