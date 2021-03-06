<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>@yield('title', config('app.name'))</title>
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="shortcut icon" href="{{ asset('faicon.png') }}" type="image/png"/>
    @livewireStyles
    <link href="{{ mix('css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/fixedheader/3.2.0/css/fixedHeader.bootstrap4.min.css" rel="stylesheet">
    @stack('stylesheet')
</head>
<body class="c-app">
@if (auth()->user() instanceof \App\Models\Admin)
    @include('layouts.navigation_admin')
@else
    @include('layouts.navigation_af')
@endif

<div class="c-wrapper">
    <header class="c-header c-header-light c-header-with-subheader">
        <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar"
                data-class="c-sidebar-show">
            <i class="c-icon c-icon-lg fas fa-bars">
            </i>
        </button>
        <a class="c-header-brand d-lg-none" href="#">
            <svg width="118" height="46" alt="CoreUI Logo">
                <use xlink:href="assets/brand/coreui.svg#full"></use>
            </svg>
        </a>
        <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar"
                data-class="c-sidebar-lg-show" responsive="true">
            <i class="c-icon c-icon-lg fas fa-bars">
            </i>
        </button>
{{--        <ul class="c-header-nav d-md-down-none">--}}
{{--            <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="#">Dashboard</a></li>--}}
{{--            <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="#">Users</a></li>--}}
{{--            <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="#">Settings</a></li>--}}
{{--        </ul>--}}
        <ul class="c-header-nav ml-auto mr-4">
            <li class="c-header-nav-item d-md-down-none mx-2"><a class="c-header-nav-link" href="#">
                    <svg class="c-icon">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-bell"></use>
                    </svg>
                </a></li>
            <li class="c-header-nav-item d-md-down-none mx-2"><a class="c-header-nav-link" href="#">
                    <svg class="c-icon">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-list-rich"></use>
                    </svg>
                </a></li>
            <li class="c-header-nav-item d-md-down-none mx-2"><a class="c-header-nav-link" href="#">
                    <svg class="c-icon">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-envelope-open"></use>
                    </svg>
                </a></li>
            <li class="c-header-nav-item dropdown"><a class="c-header-nav-link" data-toggle="dropdown" href="#"
                                                      role="button" aria-haspopup="true" aria-expanded="false">
                    <div class="c-avatar"><img class="c-avatar-img" src="https://www.gravatar.com/avatar/{{ md5(strtolower(auth()->user()->email)) }}" alt="{{ auth()->user()->email }}">
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right pt-0">
                    <div class="dropdown-header bg-light py-2"><strong>Settings</strong></div>
                    <a class="dropdown-item" href="#">
                        <svg class="c-icon mr-2">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                        </svg>
                        Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item btn-logout" href="#">
                        <svg class="c-icon mr-2">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-account-logout"></use>
                        </svg>
                        Logout</a>
                    <form action="{{ auth()->user() instanceof  \App\Models\Admin ? route('console.logout') :  route('logout') }}" method="post" id="logout-form">@csrf</form>
                </div>
            </li>
        </ul>
        <div class="c-subheader px-3">

{{--            <ol class="breadcrumb border-0 m-0">--}}
{{--                <li class="breadcrumb-item">Home</li>--}}
{{--                <li class="breadcrumb-item"><a href="#">Admin</a></li>--}}
{{--                <li class="breadcrumb-item active">Dashboard</li>--}}

{{--            </ol>--}}
        </div>
    </header>
    <div class="c-body">
        <main class="c-main">
            @yield('content')
        </main>
        <footer class="c-footer">
            <div><a href="https://coreui.io">{{ config('app.name') }}</a> © 2021.</div>
{{--            <div class="ml-auto">Powered by&nbsp;<a href="https://coreui.io/">CoreUI</a></div>--}}
        </footer>
    </div>
</div>

<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.2.0/js/dataTables.fixedHeader.min.js"></script>
@livewireScripts
@stack('javascript')
<script type="text/javascript">
    $(function () {
        $('.btn-logout').on('click', function () {
            $('#logout-form').submit();
        })
    })
</script>

</body>
</html>
