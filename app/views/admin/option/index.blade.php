@extends('admin.layouts.main')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">网站参数设置</div>
            </div>
            <div class="panel-body">
                设置网站参数以供前台调用
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="{{route('admin.option.save')}}" method="post">
                    {{Form::token()}}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">网站名</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="data[site.name]" value="{{$options['site.name'] or '站点名称'}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">主题名</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="data[site.theme]" value="{{$options['site.theme'] or 'default'}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">保存</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
<script>
    highlightMenu('admin.option.index');
</script>
@stop


