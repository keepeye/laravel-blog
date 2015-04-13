@extends('layouts.main')

@section('main')
<div class="col-md-8">
    @if(count($articles) == 0)
    <div class="gx-post">
        <div class="gx-post-body gx-box">
        :( 该TAG下还没有文章哦～
        </div>
    </div>
    @endif

    @foreach($articles as $article)
    <div class="gx-post">
        <div class="gx-post-label">{{$article->category->name}}</div>
        <div class="gx-post-body gx-box">
            <h2><a href="{{route('article.show',[$article->id])}}" class="gx-post-title">{{$article->title}}</a></h2>
            <div class="gx-post-meta">
                <span><i class="glyphicon glyphicon-time"></i>  <time>{{$article->created_at}}</time></span>
                <span>
                    <i class="glyphicon glyphicon-tags"></i>
                    @foreach($article->tags as $tag)
                    <a href="{{route('tag.show',[$tag->name])}}">{{$tag->name}}</a>&nbsp;
                    @endforeach
                </span>
            </div>
            <div class="gx-post-content">
                <div class="row" style="margin:0 -15px;">
                    @if($article->litpic != "")
                    <div class="col-md-3 gx-post-litpic">
                        <img class="img-responsive" src="{{$article->litpic}}">
                    </div>
                    <div class="col-md-9">
                        {{$article->description}}
                    </div>
                    @else
                    <div class="col-md-12">
                        <p>{{$article->description}}</p>
                    </div>
                    @endif
                </div>
                <div class="readmore">
                    <a href="{{route('article.show',[$article->id])}}">[阅读全文]</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    {{$articles->links()}}
</div>
@stop