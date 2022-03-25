@extends('layouts.dashboard')
@section('title', 'Recent News')

@section('content')
<div class="container-fluid p-0">
    <div class="row pt-4 pt-lg-5">
        <div class="col">
            <h1>Recent News</h1>
        </div>
    </div>

    <div class="row news">
        @foreach($news->take(12) as $article)
        <div class="col-md-3 article-column">
            <a href="{{ $article['url'] }}" class="card article" target="_blank">
                <div class="prooduct-details-box" style="margin-bottom: 0px;">
                    <div class="media" style="text-align: center; padding:10px; min-height:410px; border:0px;">
                        <img class="align-self-center img-fluid" src="{{ $article['image'] }}" style="max-height: 180px;" alt="#">
                        <div class="media-body">
                            <h4>{{ $article['headline'] }}</h4>
                            <div class="summary">{{ \Illuminate\Support\Str::limit($article['summary'], 150, '...') }}</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection