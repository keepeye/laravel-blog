<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <title>{{$title or '后台管理'}}</title>
    <link rel="stylesheet" href="{{url('styles/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{url('styles/css/admin/reset.css')}}"/>
    @section('extend_styles')

    @show
    <link rel="stylesheet" href="{{url('styles/css/admin/app.css')}}"/>
</head>
<body>

<div class="header">
    <nav class="navbar navbar-default navbar-static-top navbar-inverse rs-navbar" role="navigation">

        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{url('/')}}"><i class="glyphicon glyphicon-th-large"></i></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav" id="menus">

                    @foreach(Menu::navLinks() as $menu)
                    @if(empty($menu['children']))
                    <li data-menu-name="{{$menu['name']}}"><a href="{{url($menu['url'])}}">{{$menu['title']}}</a>
                    </li>
                    @else
                    <li class="dropdown">
                        <a href="{{$menu['url']}}" class="dropdown-toggle" data-toggle="dropdown">{{$menu['title']}} <span
                                class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            @foreach($menu['children'] as $childMenu)
                            <li data-menu-name="{{$childMenu['name']}}"><a href="{{url($childMenu['url'])}}">{{$childMenu['title']}}</a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif
                    @endforeach

                </ul>


                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="dropdown-toggle" href="#" data-toggle="dropdown">{{$user->first_name}} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{route('logout')}}">登出</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
</div>

<div class="body">


    <div class="main">
        <div class="container">
            @section('content')
            @show
        </div>
    </div>
</div>

<script src="{{url('js/jquery.min.js')}}"></script>
<script src="{{url('js/jquery-checkAll.js')}}"></script>
<script src="{{url('js/bootstrap.min.js')}}"></script>
<script src="{{url('js/way.js')}}"></script>

@section('extend_scripts')
@show

<script src="{{url('js/app.js')}}"></script>
@section('script')
<script>
    highlightMenu('index');
</script>
@show
<script>
    $(function(){
        $('.tip').tooltip();
    });
</script>
</body>
</html>