@include('layout.head')
<body class="hold-transition login-page dark-mode  dir-rtl">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="" class="h4"><img src="{{ asset('webassets/dist/img/download.jpg')}}" style="width:100px" /> <b> المطابع الاميرية</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">تسجيل دخول إلى نظام الفاتورة الإلكترونية </p>

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="input-group mb-3">
            <input id="email" placeholder="البريد الإلكترونى" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
            <input id="password" placeholder="كلمه المرور" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="social-auth-links text-center mt-2 mb-3">
            <button type="submit" class="btn btn-block btn-primary">
                تسجيل دخول
            </button>

          </div>
      </form>


      <!-- /.social-auth-links -->
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
@include('layout.footerScripts')

