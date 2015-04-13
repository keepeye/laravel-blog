@extends('admin.layouts.main')



@section('content')
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
          <li><a href="{{route('admin.index.index')}}">首页</a></li>
          <li><a href="{{route('admin.menu.index')}}">菜单管理</a></li>
          <li class="active">新增</li>
        </ol>

    </div>

    {{ Form::open(array('route'=>['admin.menu.store'],'method'=>'POST','role'=>'form')) }}
    <div class="col-md-3">
        <div class="alert alert-warning">
            <p class="text-info">
                提示: <br/>
                若开启权限验证，则将路由类型的url作为权限标识。
            </p>
        </div>
    </div>

    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <label>显示名</label>
                    <input class="form-control" type="text" name="data[title]"  required/>
                </div>

                <div class="form-group">
                    <label>父菜单</label>
                    <select class="form-control" name="data[pid]" >
                        <option value="0">-根菜单-</option>
                        @foreach($parents as $parent)
                        <option value="{{$parent['id']}}"   >@if($parent['level']>0){{str_repeat('&nbsp;',$parent['level']*5).'∟'}}@endif{{$parent['title']}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>节点名</label>
                    <input class="form-control" type="text" name="data[name]" value=""/>
                </div>

                <div class="form-group">
                    <label>url</label>
                    <input class="form-control" type="text" name="data[url]" value=""/>
                    <p class="help-block">留空则将节点名当作路由名称自动生成url</p>
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
    highlightMenu('admin.menu.index');
    $(function(){
        $('.tip').tooltip();
    });
</script>
@stop