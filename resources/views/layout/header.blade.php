 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('/')}}" class="brand-link">
        <img src="{{ asset('webassets/dist/img/download.jpg')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">مطابع الأميرية</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar dir-rtl">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('webassets/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{Auth::user()->username}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2 dir-rtl">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
       with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview menu-open">
                    <a href="{{url('/')}}" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            الرئيسية
                        </p>
                    </a>

                </li>
                <li class="nav-item has-treeview">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            الإعدادات
                            <i class="fas fa-angle-right left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{route('users.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p> المستخدمين </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('units.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>وحدات القياس </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('settings.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p> إعدادات عامة </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('cities.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p> المدن</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview menu-open">
                    <a href="{{route('items.index')}}" class="nav-link ">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            تكويد الأصناف
                        </p>
                    </a>

                </li>
                <li class="nav-item has-treeview menu-open">
                    <a href="{{route('clients.index')}}" class="nav-link ">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            تكويد العملاء
                        </p>
                    </a>

                </li>
                <li class="nav-item has-treeview menu-open">
                    <a href="{{route('invoices.index')}}" class="nav-link ">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            فواتير المبيعات
                        </p>
                    </a>

                </li>
                <li class="nav-item has-treeview menu-open">
                    <a href="{{route('relay.index')}}" class="nav-link ">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            ترحيل الفواتير
                        </p>
                    </a>

                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
