@extends('admin.layouts.main')

@section('extend_styles')
<link rel="stylesheet" href="{{url('styles/css/bootstrap-markdown.min.css')}}"/>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
          <li><a href="{{route('admin.index.index')}}">首页</a></li>
          <li><a href="{{route('admin.page.index')}}">单页</a></li>
          <li class="active">新建</li>
        </ol>
    </div>
    {{ Form::open(array('route'=>'admin.page.store','method'=>'post','role'=>'form')) }}
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <label for="title">标题</label>
                    <input class="form-control" id="title" name="data[title]"  type="text" placeholder="输入标题.." required/>
                </div>

                <div class="form-group">
                    <label>正文</label>
                    <span class="help-block">请用markdown语法书写正文，建议用专业编辑器写完复制到这里</span>
                    <textarea class="form-control" id="page_content" name="data[content_md]"  rows="10"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">提交</button>

            </div>
        </div>
    </div>

    {{ Form::close() }}
</div>
@stop

@section('extend_scripts')

<script src="{{url('js/markdown.js')}}"></script>
<script src="{{url('js/to-markdown.js')}}"></script>
<script src="{{url('js/bootstrap-markdown.js')}}"></script>
<script src="{{url('js/bootstrap-markdown.zh.js')}}"></script>
@stop

@section('script')
<script>
    highlightMenu('admin.page.index');
    $(function(){
        //markdown编辑器
        $("#page_content").markdown({
            language:'zh'
        });

    });
</script>
@stop