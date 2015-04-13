@extends('admin.layouts.main')

@section('content')
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
          <li><a href="{{route('admin.index.index')}}">首页</a></li>
          <li class="active">菜单管理</li>
        </ol>
    </div>
    <div class="col-md-12">
        <div class="panel">

            <div class="panel-heading">
                <div class="toolbar">
                    <a href="{{route('admin.menu.create')}}" class="btn btn-primary btn-sm">添加</a>
                    <!-- Single button -->
                    <div class="btn-group submit">
                      <button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown">
                        选中项 <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <li><a class="batchOperation" href="#" data-action="delete" data-confirm="确定删除分类及其下所有内容？">删除</a></li>
                      </ul>
                    </div>
                </div>
            </div>

            <div class="panel-body table-responsive">

                <table class="table table-condensed">

                    <thead>
                    <tr>
                        <th width="50"><input type="checkbox" id="checkall"/></th>
                        <th>id</th>
                        <th>菜单名</th>
                        <th>name</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($menus as $menu)
                    <tr>
                        <td><input class="slaves" type="checkbox" value="{{$menu['id']}}"/></td>
                        <td>{{$menu['id']}}</td>
                        <td>@if($menu['level']>0){{str_repeat('&nbsp;',$menu['level']*5).'∟'}}@endif{{$menu['title']}}</td>
                        <td>{{$menu['name']}}</td>
                        <td>
                            <a href="{{route('admin.menu.edit',['id'=>$menu['id']])}}">编辑</a>
                        </td>
                    </tr>
                    @endforeach

                    </tbody>
                </table>



            </div>

        </div>
    </div>
</div>
@stop

@section('script')
<script>
    highlightMenu('admin.menu.index');
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
        var url = "{{ route('admin.menu.batch') }}";

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
                alert('网络错误')
                console.log(textStatus+errorThrown.message)
            }
        });

    });
</script>
@stop