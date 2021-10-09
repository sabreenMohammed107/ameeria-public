@include('Layout.head')

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
                    <a href="index3.html" class="nav-link"> الرئيسية</a>
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
                        <a  href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> تسجيل خروج

                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i>تعديل بينات المستخدم

                        </a>


                </li>

            </ul>

        </nav>
        <div class="info">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->username }} <span class="caret"></span>
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
            </ul>
            {{-- <a href="edit-profile.html" class="d-block">{{Auth::user()->username}}</a> --}}
        </div>

    @include('Layout.header')

    <!-- container -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 dir-rtl">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">الرئيسية</h1>
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
    @if(Session::has('flash_success'))
                <div class="col-lg-12" style="direction: rtl;">
                    <div class="alert alert-success">
                        <strong><i class="fa fa-check-circle"></i> {!! session('flash_success') !!}</strong>
                    </div>
                </div>
            @endif
            @if(Session::has('flash_danger'))
                <div class="col-lg-12" style="direction: rtl;">
                    <div class="alert alert-danger">
                        <strong><i class="fa fa-info-circle"></i> {!! session('flash_danger') !!}</strong>
                    </div>
                </div>
            @endif
            @if(Session::has('flash_delete'))
                @section('script')
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
                @endsection
            @endif


 <!-- Main content -->
 <section class="content ">
    <div class="container-fluid dir-rtl ">

        @yield('content')
    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->
</div>

    @yield('modal')




    @include('Layout.footer')

    @include('Layout.footerScripts')
