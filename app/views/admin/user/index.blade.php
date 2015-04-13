@extends('admin.layouts.main')

@section('content')

<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
          <li><a href="{{route('admin.index.index')}}">首页</a></li>
          <li class="active">用户管理</li>
        </ol>
    </div>
    <div class="col-md-12">
        <div class="table-responsive panel">
            <div class="panel-heading">
                <div class="toolbar">
                    <!-- Single button -->
                    <div class="btn-group submit">
                      <button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown">
                        选中项 <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <li><a class="batchOperation" href="#" data-action="delete" data-confirm="确定删除这些用户？同时将删除关联的文章和单页！">删除</a></li>
                      </ul>
                    </div>
                    <a href="{{route('admin.user.create')}}" class="btn btn-primary btn-sm">新用户</a>

                </div>
            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th width="50"><input id="checkall" type="checkbox" /></th>
                        <th>Id</th>
                        <th>email</th>
                        <th>姓名</th>
                        <th>用户组</th>
                        <th>激活</th>
                        <th>修改时间</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td><input class="slaves" type="checkbox" name="delids[]" value="{{$user->id}}"/></td>
                        <td>{{$user->id}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->first_name.$user->last_name}}</td>
                        <td>
                            @foreach($user->groups as $group)
                            {{$group->name}}
                            @endforeach
                        </td>
                        <td>{{$user->activated==1?'已激活':'尚未激活'}} @if($user->activated_at) ($user->activated_at) @endif </td>
                        <td>{{$user->updated_at}}</td>
                        <td>{{$user->created_at}}</td>
                        <td><a href="{{route('admin.user.edit',$user->id)}}">编辑</a></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <nav>
                {{$users->links()}}
            </nav>
        </div>
    </div>
</div>

@stop

@section('script')
<script>
    highlightMenu('admin.user.index');
    //全选操作
    $("#checkall").checkAll(".slaves");

    //生成已选ids
    function getCheckedIds()
    {
        var ids = new Array();
        $(".slaves:checked").each(function(){
            ids.push($(this).val());
        });
        return ids;
    }


    //批量操作
    $(".batchOperation").click(function(e){
        e.preventDefault();
        var confirm = $(this).attr('data-confirm');
        var ids = getCheckedIds();
        var csrfToken = "{{ csrf_token() }}";
        var action = $(this).attr('data-action') || '';
        var url = "{{ route('admin.user.batch') }}";

        if (!action) return;

        if (confirm && !window.confirm(confirm)) {
            return false;
        }

        $.ajax({
            url : url,
            type : "post",
            data : {action:action,ids:ids,_token:csrfToken},
            success : function(res) {
                if (res && res.status == 1) {
                    alert('操作成功');
                    location.reload();
                } else {
                    alert('操作失败'+(res.msg || ''));
                }
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                alert('发生错误')
                console.log(textStatus+errorThrown.message)
            }
        });

    });
</script>
@stop