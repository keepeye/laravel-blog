@extends('admin.layouts.main')

@section('content')

<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
          <li><a href="{{route('admin.index.index')}}">首页</a></li>
          <li class="active">插件列表</li>
        </ol>
    </div>
    <div class="col-md-12">
        <div class="table-responsive panel">
            <div class="panel-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>插件名</th>
                        <th>作者</th>
                        <th>版本</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($plugins as $plugin)
                        <tr>
                            <td>{{$plugin['name']}}</td>
                            <td>{{$plugin['author']}}</td>
                            <td>{{$plugin['version']}}</td>
                            <td>安装</td>
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
    highlightMenu('admin.article.index');

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
        var url = "{{ route('admin.article.batch') }}";

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