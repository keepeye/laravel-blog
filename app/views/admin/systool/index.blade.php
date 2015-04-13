@extends('admin.layouts.main')

@section('content')
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
          <li><a href="{{route('admin.index.index')}}">首页</a></li>
          <li class="active">系统工具</li>
        </ol>
    </div>

    <div class="col-md-12">

        <div class="panel">
            <div class="panel-heading">
                <h3>缓存清理</h3>
            </div>
            <div class="panel-body">
                <a href="{{route('admin.systool.flushcache',['tag'=>'options'])}}" class="btn btn-primary">刷新站点配置</a>
                <a href="{{route('admin.systool.flushcache',['tag'=>'index.index.articles'])}}" class="btn btn-primary">清空首页缓存</a>
                <a href="{{route('admin.systool.flushcache',['tag'=>'hotTags'])}}" class="btn btn-primary">热门标签缓存</a>
                <a href="{{route('admin.systool.flushcache',['tag'=>'navList'])}}" class="btn btn-primary">导航分类缓存</a>
                <a href="{{route('admin.systool.flushcache',['tag'=>'navPages'])}}" class="btn btn-primary">导航单页缓存</a>
                <a href="{{route('admin.systool.flushcache')}}" class="btn btn-danger">清空全站缓存</a>
            </div>

        </div>
    </div>
</div>
@stop