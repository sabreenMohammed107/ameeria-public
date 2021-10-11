@include('layout.head')

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light dir-rtl">
            <!-- right navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <!-- <a href="{{ route('/') }}" class="nav-link"> الرئيسية</a> -->
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <div class="image">
                            <img src="{{ asset('webassets/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" style="width: 30px" alt="User Image">
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
                        <span class="dropdown-item dropdown-header">{{Auth::user()->username}}</span>
                        <div class="dropdown-divider"></div>
                        <a href="{{ url('edit-user-profile/'.Auth::user()->id) }}" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i>تعديل بينات المستخدم
                        </a>
                        <div class="dropdown-divider"></div>
                        <a  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> تسجيل خروج
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>

    @include('layout.header')

    <!-- container -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 dir-rtl">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@yield('title')</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                       @yield('crumb')
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
           
         <!-- Main content -->
         <section class="content ">
            <div class="container-fluid dir-rtl ">
                @include('layout.messages')

                @yield('content')
            </div>
            <!--/. container-fluid -->
        </section>
        <!-- /.content -->
    </div>

@yield('modal')



@include('layout.footer')

@include('layout.footerScripts')