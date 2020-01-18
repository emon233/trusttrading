<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Trust Trading</title>
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="/css/metisMenu.min.css" rel="stylesheet">
    <link href="/css/sb-admin-2.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/select2.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- Scripts -->
    
    <script src="/js/myapp.js"></script>
    <script src="/js/jquery.js"></script>
    <script src="/js/ajax.js"></script>
    <script src="/js/bootstrap.js"></script>
    <script type="text/javascript" charset="utf8" src="/js/select2.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    
    <script src="/js/metisMenu.min.js"></script>
    <script src="/js/bootstrap-treeview.js"></script>
    <script src="/js/sb-admin-2.js"></script>
    
    <style>
    .sidenav {
        height: 100%; /* 100% Full-height */
        width: 0; /* 0 width - change this with JavaScript */
        position: fixed; /* Stay in place */
        z-index: 1; /* Stay on top */
        top: 0; /* Stay at the top */
        left: 0;
        background-color: transparent; /* Black*/
        overflow-x: hidden; /* Disable horizontal scroll */
        margin-top: 60px; /* Place content 60px from the top */
        transition: 0.5s; /* 0.5 second transition effect to slide in the sidenav */
    }

    .tree, .tree ul {
            margin:0;
            padding:0;
            list-style:none
        }
        .tree ul {
            margin-left:1em;
            position:relative
        }
        .tree ul ul {
            margin-left:.5em
        }
        .tree ul:before {
            content:"";
            display:block;
            width:0;
            position:absolute;
            top:0;
            bottom:0;
            left:0;
            border-left:1px solid
        }
        .tree li {
            margin:0;
            padding:0 1em;
            line-height:2em;
            color:#369;
            position:relative
        }
        .tree ul li:before {
            content:"";
            display:block;
            width:10px;
            height:0;
            border-top:1px solid;
            margin-top:-1px;
            position:absolute;
            top:1em;
            left:0
        }
        .tree ul li:last-child:before {
            background:#fff;
            height:auto;
            top:1em;
            bottom:0
        }
        .indicator {
            margin-right:5px;
        }
        .tree li a {
            text-decoration: none;
            color:#369;
        }
        .tree li button, .tree li button:active, .tree li button:focus {
            text-decoration: none;
            color:#369;
            border:none;
            background:transparent;
            margin:0px 0px 0px 0px;
            padding:0px 0px 0px 0px;
            outline: 0;
        }

        .footer{
            background:#b4b4b4;
            margin:20px 0px 0px 0px;
            padding:20px 20px 20px 0px;
        }

</style>
</head>
<body>
    <div id="wrapper">
    <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}">
                    Trust Trading
                </a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
            @include('layouts.sidebar')
        </nav>
        
        <div class="container" id="page-wrapper">
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if(Session::has('flash_message'))
                <div class="alert alert-success">
                    {{ Session::get('flash_message') }}
                </div>
            @endif

            @if(Session::has('error_message'))
                <div class="alert alert-danger">
                    {{ Session::get('error_message') }}
                </div>
            @endif

            @if(Session::has('daily_zone_deliverman_combo_id'))
                <div>
                    <input type="hidden" id="daily_zone_deliverman_combo_id" name="daily_zone_deliverman_combo_id" value="{{ Session::get('daily_zone_deliverman_combo_id') }}"/>
                </div>
            @endif
            @yield('content')
            
        </div>
    </div>
    <div class="footer">
        <div style="text-align:right;">
            <h2>Contact Us</h2>
            <ul>
                <h5><span class="text">203 Fake St. Khulna, Bangladesh </span><i class="fas fa-map-marker-alt"></i></h5>
                <h5><span class="text">+880 1521-441218 </span><i class="fas fa-mobile-alt"></i></h5>
                <h5><span class="text">sazid140233@gmail.com </span><i class="fas fa-envelope"></i></h5>
            </ul>
        </div>
        <div style="text-align:center;">
            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This Product is made by <span><a href="https://mdsazidhossain.info" target="_blank">Md. Sazid Hossain (Emon)</a></span>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
        </div>
    </div>
    
</body>

<script>
    $('#add_new').click(function() {
        var add_div = document.getElementById('add_div');
        if(add_div != null)
        {
            var add_div = $('#add_div');
        }
        else 
        {
            var add_div = $('#edit_div');
        }
        
        if (add_div.attr('hidden')) 
        {
            add_div.removeAttr('hidden');
            document.getElementById('add_new').innerText = 'Close';
            
        } 
        else 
        {
            add_div.prop('hidden', true);
            document.getElementById('add_new').innerText = 'ADD NEW';
        }
    });

    $('.edit').click(function() {
        var add_div = document.getElementById('add_div');
        if(add_div != null)
        {
            add_div.id = "edit_div";
            var add_div = $('#edit_div');
        }

        else
        {
            add_div = document.getElementById('edit_div');
            add_div.id = "add_div";
            var add_div = $('#add_div');
        }
        
        if (add_div.attr('hidden')) 
        {
            add_div.removeAttr('hidden');
            document.getElementById('add_new').innerText = 'Close';
            
        } 
        else 
        {
            add_div.prop('hidden', true);
            document.getElementById('add_new').innerText = 'ADD NEW';
        }
    });

    $("#brand_id").change(function () {
        if ($(this).val() != "") {
            var brand_id = $('#brand_id').val();
            $("#product_id").html("<option value=''>Loading...</option>");
            var url = "/productsbybrand";
            $.ajax({
                url:url,
                method:'get',
                data:{
                    brand_id:brand_id,
                },
                dataType:'json',
                success:function(data)
                {
                    var HTML = "";
                    HTML += "<option value=''>--Select Product--</option>";
                    for (var i in data) {
                        HTML += "<option value='" + data[i].id + "'>" + data[i].product_name + "</option>";
                    }
                    $("#product_id").html(HTML);
                },
                error:function(data)
                {
                    console.log(data);
                }
            });
            // $.get("/product/Getajax", {"brand_id": $(this).val()}, function (data) {
            //     console.log(data);
            //     var HTML = "";
            //     HTML += "<option value=''>--Select Product--</option>";
            //     for (var i in data) {
            //         HTML += "<option value='" + data[i].id + "'>" + data[i].product_name + "</option>";
            //     }
            //     $("#product_id").html(HTML);
            // });
        }
        else {
            $("#product_id").html("");
        }
    });
</script>

</html>




