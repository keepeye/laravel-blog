@extends('admin.layouts.main')

@section('extend_styles')
<link rel="stylesheet" href="{{url('styles/css/bootstrap-datetimepicker.min.css')}}"/>
<link rel="stylesheet" href="{{url('styles/css/bootstrap-markdown.min.css')}}"/>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
          <li><a href="{{route('admin.index.index')}}">首页</a></li>
          <li><a href="{{route('admin.article.index')}}">文章</a></li>
          <li class="active">新建</li>
        </ol>
    </div>
    {{ Form::open(array('route'=>'admin.article.store','method'=>'post','role'=>'form')) }}
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <label for="title">标题</label>
                    <input class="form-control" id="title" name="data[title]"  type="text" placeholder="输入标题.." required/>
                </div>

                <div class="form-group">
                    <label for="description">摘要</label>
                    <span class="help-block">写一段关于文章的简要介绍，将显示在列表页</span>
                    <textarea class="form-control" id="description" name="data[description]"  rows="3" placeholder="输入摘要.."></textarea>

                </div>

                <div class="form-group">
                    <label>正文</label>
                    <span class="help-block">请用markdown语法书写正文，建议用专业编辑器写完复制到这里</span>
                    <textarea class="form-control" id="article_content" name="data[content_md]"  rows="10"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">提交</button>

            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <label for="created_at"><i class="glyphicon glyphicon-time"></i>发布日期</label>
                    {{Form::text('data[created_at]',date('Y-m-d H:i:s'),['class'=>'form-control','id'=>'created_at'])}}
                </div>
                <div class="form-group">
                    <label>分类</label>
                    <select class="form-control" name="data[cid]">
                        <option value="0">默认分类</option>
                        @foreach($categories as $category)

                        <option value="{{$category['id']}}" @if($category['final'] == 0) disabled @endif >@if($category['level']>0){{str_repeat('&nbsp;',$category['level']*5).'∟'}}@endif{{$category['name']}}</option>

                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>标签</label>
                    {{Form::text('tags','',['class'=>'form-control'])}}
                    <span class="help-block">每个标签以","分隔,最多5个</span>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>
@stop

@section('extend_scripts')
<script src="{{url('js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{url('js/bootstrap-datetimepicker.zh-CN.js')}}"></script>
<script src="{{url('js/markdown.js')}}"></script>
<script src="{{url('js/to-markdown.js')}}"></script>
<script src="{{url('js/bootstrap-markdown.js')}}"></script>
<script src="{{url('js/bootstrap-markdown.zh.js')}}"></script>
@stop

@section('script')
<script>
    highlightMenu('admin.article.index');
    $(function(){
        //markdown编辑器
        $("#article_content").markdown({
            language:'zh'
        });
        //日期插件
        $("#created_at").datetimepicker({
            format: 'yyyy-mm-dd hh:ii:ss',
            startDate: '-3d',
            todayBtn:true,
            language:'zh-CN',
            autoclose:true
        });
    });
</script>
@stop