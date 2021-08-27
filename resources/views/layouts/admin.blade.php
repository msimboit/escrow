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
  <link rel="icon" href="{{ asset('images/favicon.png') }}">

  <!-- Google Font: Source Sans Pro -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

  <!-- For Searches -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
 
  <link rel="stylesheet" type="text/css" href="{{asset('jqueryui/jquery-ui.min.css')}}">
  <script src="{{asset('jquery-3.3.1.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('jqueryui/jquery-ui.min.js')}}" type="text/javascript"></script>

  <style>
    html, body {
      font-family: 'Nunito', sans-serif;
      font-weight: 400;
      height: 100vh;
      margin: 0;
    }
  </style>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href=" {{ route('home') }}" class="nav-link">Home</a>
      </li>
      <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> -->
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <!-- <a href="index3.html" class="brand-link">
      <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Escrow</span>
    </a> -->

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <!-- <div class="image">
          <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div> -->
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->first_name }}  {{ Auth::user()->last_name }}</a>
        </div>
        <div class="info">
            <a class="d-block" href="{{ route('logout') }}">
                                        {{ __('Logout') }}
            </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              @if(Auth::user()->role === 'vendor' || Auth::user()->role === 'admin')
              <p>
                Buyers
                <i class="right fas fa-angle-left pt-2"></i>
              </p>
              @endif

              @if(Auth::user()->role === 'client' || Auth::user()->role === 'admin')
              <p>
                Vendors
                <i class="right fas fa-angle-left pt-2"></i>
              </p>
              @endif

            </a>
            <ul class="nav nav-treeview">
              @if(Auth::user()->role === 'vendor' || Auth::user()->role === 'admin')
              <li class="nav-item">
                <a href="{{ route('clients') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Buyers</p>
                </a>
              </li>
              @endif

              @if(Auth::user()->role === 'client' || Auth::user()->role === 'admin')
              <li class="nav-item">
                <a href="{{ route('vendors') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Vendors</p>
                </a>
              </li>
              @endif
            </ul>
          </li>

          @if(Auth::user()->role === 'admin')
          <li class="nav-item">
            <a href="{{ route('abanks') }}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Acquiring Banks
              </p>
            </a>
          </li>
          @endif
          @if(Auth::user()->role === 'admin')
          <li class="nav-item">
            <a href="{{ route('products') }}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Products
              </p>
            </a>
          </li>
          @endif
          <li class="nav-item">
            <a href="{{ route('transactions') }}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Transactions
              </p>
            </a>
          </li>
          @if(Auth::user()->role === 'admin')        
          <li class="nav-item">
            <a href="{{ route('deposits') }}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Deposits
              </p>
            </a>
          </li>
          @endif

          @if(Auth::user()->role === 'admin')
          <li class="nav-item">
            <a href="{{ route('payments') }}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Payments
              </p>
            </a>
          </li>
          @endif
          @if(Auth::user()->role === 'admin')
          <li class="nav-item">
            <a href="{{ route('settlements') }}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Settlements
   
              </p>
            </a>
          </li>
          @endif

          <li class="nav-item">
            <a href="{{ route('deliveries') }}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Deliveries    
              </p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="{{ route('rejections') }}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Disputes
              </p>
            </a>
          </li>

          
          @if(Auth::user()->role === 'admin')   
          <li class="nav-item">
            <a href="{{ route('mediations') }}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Mediation
           
              </p>
            </a>
          </li>
          @endif

          @if(Auth::user()->role === 'admin')        
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Reports
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('clients') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Transactions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('vendors') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Payments</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('vendors') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Products Movements</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('vendors') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Movement By Location</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
        
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
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
