@extends('admin.layouts.main')



@section('content')
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
          <li><a href="{{route('admin.index.index')}}">首页</a></li>
          <li><a href="{{route('admin.category.index')}}">分类</a></li>
          <li class="active">创建</li>
        </ol>
    </div>
    {{ Form::open(array('route'=>'admin.category.store','method'=>'post','role'=>'form')) }}
    <div class="col-md-3">
        <div class="alert alert-warning">
            <p class="text-info">
                提示: <br/>
                非最终分类无法作父分类 <br/>
                最终分类才允许发布文章
            </p>
        </div>
    </div>

    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <label>分类名</label>
                    <input type="text" name="data[name]" class="form-control"  placeholder="输入分类名.." required/>
                </div>
                <div class="form-group">
                    <label>父分类</label>
                    <select name="data[parent]" class="form-control">
                        <option value="0">-根分类-</option>
                        @foreach($parents as $parent)
                        @if($parent['final'] != 1)
                        <option value="{{$parent['id']}}" @if($parent['final'] > 0) disabled @endif >@if($parent['level']>0){{str_repeat('&nbsp;',$parent['level']*5).'∟'}}@endif{{$parent['name']}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>最终分类 <a class="tip" href="#" data-placement="right" data-toggle="tooltip" title="最终分类才允许发布文章，非最终分类才允许添加子分类">(?)</a></label>
                    <div>
                        <label class="checkbox-inline">
                            <input type="radio" name="data[final]" value="0" checked> 否
                        </label>
                        <label class="checkbox-inline">
                            <input type="radio" name="data[final]" value="1"> 是
                        </label>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">提交</button>

            </div>
        </div>
    </div>

    {{ Form::close() }}

</div>
@stop



@section('script')
<script>
    highlightMenu('admin.category.index');
</script>
@stop