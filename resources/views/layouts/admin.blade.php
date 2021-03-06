<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Escrow | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="_token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">

  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('login_assets/img/favicon.png') }}">

  <!-- Google Font: Source Sans Pro -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>

  <!-- For Searches -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
 
  <link rel="stylesheet" type="text/css" href="{{asset('jqueryui/jquery-ui.min.css')}}">
  <script src="{{asset('jquery-3.3.1.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('jqueryui/jquery-ui.min.js')}}" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.4/axios.min.js" integrity="sha512-lTLt+W7MrmDfKam+r3D2LURu0F47a3QaW5nF0c6Hl0JDZ57ruei+ovbg7BrZ+0bjVJ5YgzsAWE+RreERbpPE1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <!-- For ChartJS -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  
  <style>
    html, body {
      font-family: 'Nunito', sans-serif;
      font-weight: 400;
      height: 100vh;
      margin: 0;
    }
    #flagged {
      position: relative;
      height: 100%;
    }
    #flagged:before {
      content: " ";
      position: absolute;
      top: 0;
      bottom:0;
      left: 0;
      background: url("../images/favicon.png");
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      z-index: -1;
      opacity: 0.2;
    }

    /* Loader Styles start here */
.loader-wrapper {
  --line-width: 5px;
  --curtain-color: #f1faee;
  --outer-line-color: #ee0e6c;
  --middle-line-color: ##0D103E;
  --inner-line-color: #1d3557;
  position:fixed;
  top:0;
  left:0;
  width:100%;
  height:100%;
  z-index:1000;
}

.loader {
  display:block;
  position: relative;
  top:50%;
  left:50%;
/*   transform: translate(-50%, -50%); */
  width:150px;
  height:150px;
  margin:-75px 0 0 -75px;
  border:var(--line-width) solid transparent;
  border-top-color: var(--outer-line-color);
  border-radius:100%;
  -webkit-animation: spin 2s linear infinite;
          animation: spin 2s linear infinite;
  z-index:1001;
}

.loader:before {
  content:"";
  position: absolute;
  top:4px;
  left:4px;
  right:4px;
  bottom:4px;
  border:var(--line-width) solid transparent;
  border-top-color: var(--inner-line-color);
  border-radius:100%;
  -webkit-animation: spin 3s linear infinite;
          animation: spin 3s linear infinite;
}

.loader:after {
  content:"";
  position: absolute;
  top:14px;
  left:14px;
  right:14px;
  bottom:14px;
  border:var(--line-width) solid transparent;
  border-top-color: var(--middle-line-color);
  border-radius:100%;
  -webkit-animation: spin 1.5s linear infinite;
          animation: spin 1.5s linear infinite;
}

@-webkit-keyframes spin {
  0%   { 
    -webkit-transform: rotate(0deg); 
      -ms-transform: rotate(0deg); 
          transform: rotate(0deg);
  }
  100% { 
    -webkit-transform: rotate(360deg); 
      -ms-transform: rotate(360deg); 
          transform: rotate(360deg);
  }
}
@keyframes spin {
  0%   { 
    -webkit-transform: rotate(0deg); 
      -ms-transform: rotate(0deg); 
          transform: rotate(0deg);
  }
  100% { 
    -webkit-transform: rotate(360deg); 
      -ms-transform: rotate(360deg); 
          transform: rotate(360deg);
  }
}

.loader-wrapper .loader-section {
  position:fixed;
  top:0;
  background:var(--curtain-color);
  width:51%;
  height:100%;
  z-index:1000;
}

.loader-wrapper .loader-section.section-left {
  left:0
}
.loader-wrapper .loader-section.section-right {
  right:0;
}

/* Loaded Styles */ 
.loaded .loader-wrapper .loader-section.section-left {
  transform: translateX(-100%);
  transition: all 0.7s 0.3s cubic-bezier(0.645,0.045,0.355,1.000);
}
.loaded .loader-wrapper .loader-section.section-right {
  transform: translateX(100%);
  transition: all 0.7s 0.3s cubic-bezier(0.645,0.045,0.355,1.000);
}
.loaded .loader {
  opacity: 0;
  transition: all 0.3s ease-out;
}
.loaded .loader-wrapper {
  visibility: hidden;
  transform:translateY(-100%);
  transition: all .3s 1s ease-out;
}
  </style>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="loader-wrapper">
  <div class="loader"></div>
  <div class="loader-section section-left"></div>
  <div class="loader-section section-right"></div>
</div>
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav ml-4">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-sm-inline-block ml-4">
        <a href=" {{ route('home') }}" class="nav-link">Home</a>
      </li>
      <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> -->
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar elevation-5" style="overflow:hidden;background-color: #0D103E; !important">
    <div class="p-2">
      <a href="{{ route('home') }}" class="brand-link">
        <!-- <img src="{{ asset('login_assets/img/logo-13e.png') }}" alt="SupamallEscrow Logo" class="brand-image img-circle elevation-5"
            style="opacity: 1"> -->
        <span class="brand-text font-weight-light" style="color: #fff; font-size:2rem;"><strong>SUPAMALLESCROW <hr style="height: 1px; background-color: #ccc; border: none; padding-right:5px;"></strong></span>
      </a>
    </div>
  

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <!-- <div class="image">
          <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div> -->
        <div class="info mx-2">
          <a href="{{ route('profile') }}" class="d-block" style="color: #fff; text-decoration:none;"><strong>Hello {{ Auth::user()->first_name }}</strong></a>
        </div>
      </div>

      <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-between">
        <div class="info mx-2">
            <a class="d-block" href="{{ route('profile') }}" style="color: #fff; !important">
                                        <strong>{{ __('Profile') }}</strong>
            </a>
           
        </div>
        <div class="info mx-2">
            <a class="d-block" href="{{ route('logout') }}" style="color: #fff; !important">
                                        <strong>{{ __('Logout') }}</strong>
            </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
          @if(Auth::user()->role === 'admin' || Auth::user()->role === 'customer_care')
          <li class="nav-item mb-2">
            <strong><a href="{{ route('vendors') }}" class="nav-link" style="background-color:#ee0e6c; !important">
              <i class="far fa-circle nav-icon"></i>
              <p style="color: #fff; !important">Vendors</p>
            </a></strong>
          </li>

          <li class="nav-item mb-2">
            <strong><a href="{{ route('clients') }}" class="nav-link" style="background-color: #ee0e6c; !important">
              <i class="far fa-circle nav-icon"></i>
              <p style="color: #fff; !important">Buyers</p>
            </a></strong>
          </li>
          @endif

          @if(Auth::user()->role === 'admin')
          <li class="nav-item mb-2">
            <strong><a href="{{ route('abanks') }}" class="nav-link" style="background-color: #ee0e6c; !important">
              <i class="far fa-circle nav-icon"></i>
              <p style="color: #fff; !important">
                Acquiring Banks
              </p>
            </a></strong>
          </li>
          @endif
          <li class="nav-item mb-2">
            <strong><a href="{{ route('transactions') }}" class="nav-link" style="background-color: #ee0e6c; !important">
              <i class="far fa-circle nav-icon"></i>
              <p style="color: #fff; !important">
                Transactions
              </p>
            </a></strong>
          </li>
          @if(Auth::user()->role === 'admin' || Auth::user()->role === 'customer_care')        
          <li class="nav-item mb-2">
            <strong><a href="{{ route('deposits') }}" class="nav-link" style="background-color: #ee0e6c; !important">
              <i class="far fa-circle nav-icon"></i>
              <p style="color: #fff; !important">
                Deposits
              </p>
            </a></strong>
            
          </li>
          @endif

          @if(Auth::user()->role === 'admin' || Auth::user()->role === 'customer_care')
          <li class="nav-item mb-2">
            <strong><a href="{{ route('payments') }}" class="nav-link" style="background-color: #ee0e6c; !important">
              <i class="far fa-circle nav-icon"></i>
              <p style="color: #fff; !important">
                Settlements By Escrow
              </p>
            </a></strong>
          </li>
          @endif

          <li class="nav-item mb-2">
            <strong><a href="{{ route('deliveries') }}" class="nav-link" style="background-color: #ee0e6c; !important">
              <i class="far fa-circle nav-icon"></i>
              <p style="color: #fff; !important">
                Deliveries    
              </p>
            </a></strong>
            
          </li>
          
          <li class="nav-item mb-2">
            <strong><a href="{{ route('rejections') }}" class="nav-link" style="background-color: #ee0e6c; !important">
              <i class="far fa-circle nav-icon"></i>
              <p style="color: #fff; !important">
                Disputes
              </p>
            </a></strong>
          </li>

          @if(Auth::user()->role === 'admin' || Auth::user()->role === 'customer_care')
          <li class="nav-item mb-2">
            <strong><a href="{{ route('completed') }}" class="nav-link" style="background-color: #ee0e6c; !important">
              <i class="far fa-circle nav-icon"></i>
              <p style="color: #fff; !important">
                Completed Transactions
              </p>
            </a></strong>
          </li>
          @endif
        
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color:#fff;">
    <!-- Content Header (Page header) -->
   
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content" style="background-color:#fff;">
    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

    @if (session('alert'))
        <div class="alert alert-danger" role="alert">
            {{ session('alert') }}
        </div>
    @endif
    @yield('content')
    @yield('scripts')
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer hidden-print">
    <strong>Copyright &copy; 2021 <a href="http://msimboit.net/" target="_blank">Msimbo IT</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<script>
    window.addEventListener('load',function(){
  document.querySelector('body').classList.add("loaded")  
});

  </script>
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<script src="{{ asset('dist/js/manInput.js') }}"></script>
</body>
</html>
