@extends('layouts.main')

@section('main')
<div class="col-md-12 ">
    <div class="gx-post">
    <div class="gx-post-body gx-box " style="background-color: #f5f5d5;">
        <h2 class="gx-post-title text-center">{{$page->title}}</h2>

        <div class="gx-post-content" >
            <div class="row" style="margin:0 -15px;">
                <div class="col-md-12 gx-read-content">
                    {{$page->content}}
                </div>
            </div>
        </div>
        <p></p>
        <div class="gx-post-meta text-right">
            <span><i class="glyphicon glyphicon-time"></i>  <time>{{$page->created_at}}</time></span>
        </div>
    </div>
    </div>


</div>
@stop

@section('sidebar')
@stop