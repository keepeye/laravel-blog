@extends('admin.layouts.main')

@section('content')
<div class="row">
    <div class="col-md-12">
        <p class="text-info">上次登陆：{{$user->last_login}}</p>
        <h3>全局统计</h3>
        <ul>
            <li>共 <strong>{{$counts['category_total']}}</strong> 个分类</li>
            <li>共 <strong>{{$counts['article_total']}}</strong> 篇文章</li>
            <li>共 <strong>{{$counts['page_total']}}</strong> 个单页</li>
            <li>共 <strong>{{$counts['user_total']}}</strong> 个用户</li>
        </ul>
    </div>
</div>
@stop