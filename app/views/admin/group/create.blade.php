@extends('admin.layouts.main')



@section('content')
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
          <li><a href="{{route('admin.index.index')}}">首页</a></li>
          <li><a href="{{route('admin.group.index')}}">用户组管理</a></li>
          <li class="active">创建</li>
        </ol>
    </div>
    {{ Form::open(array('route'=>'admin.group.store','method'=>'post','role'=>'form','class'=>'form-horizontal')) }}
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-md-2 control-label">组名</label>
                            <div class="col-md-4">
                                <input type="text" name="data[name]" class="form-control"  placeholder="请输入用户组名称.." required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">权限</label>
                            <div class="col-md-10">
                            <ul id="group_menus">
                                <li><input type="checkbox" name="data[permissions][superuser]" value="1"/> <span class="text-danger">超级权限 (无视所有权限)</span></li>
                                @foreach($menus as $menu)
                                    <li data-level="{{$menu['level']}}">
                                    {{str_repeat('&nbsp;',$menu['level']*5)}}
                                    @if($menu['name'] != '')
                                        <input type="checkbox" name="data[permissions][{{$menu['name']}}]" value="1"/> {{$menu['title']}}
                                    @else
                                        <input type="checkbox"/> {{$menu['title']}}
                                    @endif
                                    </li>
                                @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                              <button type="submit" class="btn btn-primary">提交</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}

</div>
@stop



@section('script')
<script>
    highlightMenu('admin.group.index');
    $("#group_menus > li > input[type=checkbox]").click(function(){
        var li = $(this).parent();
        var level = li.attr('data-level') || "0";
        var checked = $(this).prop('checked');
        li.nextUntil("li[data-level="+level+"]").find("input[type=checkbox]").prop('checked',checked);
    });
</script>
@stop