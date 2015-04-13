@extends('admin.layouts.main')



@section('content')
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
          <li><a href="{{route('admin.index.index')}}">首页</a></li>
          <li><a href="{{route('admin.user.index')}}">用户管理</a></li>
          <li class="active">创建新用户</li>
        </ol>
    </div>
    {{ Form::open(array('route'=>'admin.user.store','method'=>'post','role'=>'form','class'=>'form-horizontal')) }}
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-md-2 control-label">邮箱</label>
                            <div class="col-md-10">
                                <input type="email" name="data[email]" class="form-control"  placeholder="请输入合法邮箱.." required/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">密码</label>
                            <div class="col-md-10">
                                <input type="text" name="data[password]" class="form-control"  placeholder="请设置密码.." required/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">姓名</label>
                            <div class="col-md-10">
                                <input type="text" name="data[first_name]" class="form-control"  value="张三" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">用户组</label>
                            <div class="col-md-10">
                                @foreach($groups as $group)
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="groups[]"  value="{{$group->id}}"> {{$group->name}}
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">是否激活</label>
                            <div class="col-md-10">
                                <label class="checkbox-inline">
                                    <input type="radio" name="data[activated]" value="1" checked> 是
                                </label>
                                <label class="checkbox-inline">
                                    <input type="radio" name="data[activated]" value="0" > 否
                                </label>
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
    highlightMenu('admin.user.index');
</script>
@stop