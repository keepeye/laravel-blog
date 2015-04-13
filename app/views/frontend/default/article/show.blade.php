@extends('layouts.main')

@section('main')
<div class="col-md-12 ">
    <div class="gx-post">
    <div class="gx-post-body gx-box " style="background-color: #f5f5d5;">
         <h1 class="gx-post-title text-center">{{$article->title}}</h1>

        <div class="gx-post-content" >
            <div class="row" style="margin:0 -15px;">
                <div class="col-md-12 gx-read-content">
                    {{$article->content}}
                </div>
            </div>
        </div>
        <p></p>
        <div class="gx-post-meta text-right">
            <span><i class="glyphicon glyphicon-time"></i>  <time>{{$article->created_at}}</time></span>
            <span>
                <i class="glyphicon glyphicon-tags"></i>
                @foreach($article->tags as $tag)
                <a href="{{route('tag.show',[$tag->name])}}">{{$tag->name}}</a>&nbsp;
                @endforeach
            </span>
        </div>
    </div>
    </div>


</div>
@stop

@section('sidebar')
@stop

@section('script')
<script>
    highlightNav('nav_cid_{{$article->cid}}');
</script>
@stop