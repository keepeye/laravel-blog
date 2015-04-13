<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" id="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{$description or ''}}" />
    <title>{{$title or ""}}{{Config::get('site.name','我的网站')}}</title>
    <link rel="stylesheet" href="{{url('styles/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{url('styles/css/bootstrap-theme.min.css')}}"/>
    <link rel="stylesheet" href="{{url('styles/css/app.css')}}"/>
</head>
<body>

<div class="gx-heading">
    <div class="container gx-banner hidden-xs hidden-sm">
        <div class="gx-logo">{{Config::get('site.name','我的网站')}}</div>

    </div>

    <nav class="navbar navbar-static-top gx-navbar" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand hidden-md hidden-lg" href="#"><i class="glyphicon glyphicon-home"></i> 我的博客</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li id="nav_home"><a href="{{url('/')}}">首页</a></li>
                    @foreach(Category::getNavList() as $k => $category)
                    @if(empty($category['offSpring']))
                    <li id="nav_cid_{{$category['id']}}"><a href="{{route('category.show',[$category['id']])}}">{{$category['name']}}</a></li>
                    @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{$category['name']}} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            @foreach($category['offSpring'] as $offSpring)
                            @if($offSpring['final'] == '1')
                            <li id="nav_cid_{{$category['id']}}"><a href="{{route('category.show',[$offSpring['id']])}}">{{$offSpring['name']}}</a></li>
                            @endif
                            @endforeach
                        </ul>
                    </li>
                    @endif
                    @endforeach
                    <!--单页-->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">更多 <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            @foreach(Page::getNavPages() as $page)
                            <li><a href="{{route('page.show',[$page['id']])}}">{{$page['title']}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>

<div class="container gx-middle">
    <div class="row">

        @section('main')
        <div class="col-md-8">
            主内容区域
        </div>
        @show
        @section('sidebar')
        <div class="col-md-4">
            <div class="gx-sidebar gx-sidebar-index">

                <div class="gx-box">
                    <form id="form-search" role="form" action="http://www.baidu.com/s" onsubmit="return false;">
                        <div class="row">
                            <div class="col-md-9" >
                                <div class="form-group">
                                    <input type="text" class="form-control gx-input-text"  placeholder="请输入关键词..." name="wd">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn gx-btn-search">搜 索</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="gx-box">
                    <div class="gx-box-title">
                        热门标签
                    </div>
                    <div class="gx-box-body">
                        <div class="gx-hottest-tags">
                            @foreach(Tag::getHotTags() as $tag)
                            <a href="{{route('tag.show',[$tag->name])}}" class="label label-default" title="{{$tag->weight}}篇文章">{{$tag->name}}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @show
    </div>
</div>

<div class="gx-footer">
    <div class="gx-copyright">
        <div class="container">
            Copyright @ 2015 by 吾爱.All rights reserved.
            <span class="pull-right">
                邮箱：carlton.cheng#foxmail.com (#换成@)
            </span>
        </div>
    </div>
</div>

<script src="{{url('js/jquery.min.js')}}"></script>
<script src="{{url('js/bootstrap.min.js')}}"></script>

<script>
    function highlightNav(id)
    {
        if (id=="") {
            return;
        }
        var nav = $("#"+id);
        nav.addClass('active');
        //如果是子菜单，向上寻找主菜单并高亮
        if (nav.parent('ul.dropdown-menu').length > 0) {
            nav.parent().parent().addClass('active');
        }
    }
</script>

<script>
    $("#form-search").on('submit',function(){
        var action = $(this).attr('action');
        var wd = 'site:{{parse_url(Config::get('app.url'),PHP_URL_HOST)}}%20'+$(this).find("[name=wd]:first").val();
        window.open(action+'?wd='+wd);
    })
</script>

@section('script')

@show
</body>
</html>