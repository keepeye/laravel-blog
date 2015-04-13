@extends('admin.layouts.main')

@section('content')

<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
          <li><a href="{{route('admin.index.index')}}">首页</a></li>
          <li class="active">文章列表</li>
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
                        <li><a class="batchOperation" href="#" data-action="delete" data-confirm="确定删除这些文章？">删除</a></li>
                      </ul>
                    </div>
                    <a href="{{route('admin.article.create')}}" class="btn btn-primary btn-sm">撰写文章</a>
                    <div class="pull-right">
                        <form class="form-inline" method="get" action="{{route('admin.article.index')}}">
                            <div class="form-group form-group-sm">
                                <label class="sr-only">关键词</label>
                                <input type="text" name="title" class="form-control" placeholder="标题关键词"/>
                            </div>
                            <div class="form-group form-group-sm">
                                <label class="sr-only">分类</label>
                                <select name="cid" class="form-control">
                                    <option value="0">所有分类</option>
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">查询</button>
                        </form>

                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th width="50"><input id="checkall" type="checkbox" /></th>
                        <th>Id</th>
                        <th>标题</th>
                        <th>分类</th>
                        <th>作者</th>
                        <th>修改时间</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($articles as $article)
                    <tr>
                        <td><input class="slaves" type="checkbox" name="delids[]" value="{{$article->id}}" /></td>
                        <td>{{$article->id}}</td>
                        <td><a href="{{route('article.show',[$article->id])}}">{{$article->title}}</a></td>
                        <td>@if($article->cid > 0) {{$article->category->name or '-分类不存在-'}} @else -未分类- @endif </td>
                        <td>{{$article->user->first_name}}</td>
                        <td>{{$article->updated_at}}</td>
                        <td>{{$article->created_at}}</td>
                        <td><a href="{{route('admin.article.edit',$article->id)}}">编辑</a></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <nav>
                {{$articles->links()}}
            </nav>
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