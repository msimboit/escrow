<!doctype html>
<html class="no-js" lang="">



<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>SupamallEscrow | Login and Register </title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="_token" content="{{ csrf_token() }}">
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('login_assets/img/favicon.png') }}">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ asset('login_assets/css/bootstrap.min.css')}}">
	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="{{ asset('login_assets/css/fontawesome-all.min.css') }}">
	<!-- Flaticon CSS -->
	<link rel="stylesheet" href="{{ asset('login_assets/font/flaticon.css') }}">
	<!-- Google Web Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap" rel="stylesheet">
	<!-- Custom CSS -->
	<link rel="stylesheet" href="{{ asset('login_assets/style.css')}}">
</head>

<body>
	<!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
	<section class="fxt-template-animation fxt-template-layout13">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6 col-12 order-md-2 fxt-bg-wrap">
					<div class="fxt-bg-img" data-bg-image="{{ asset('login_assets/img/figure/bg13-l.jpg') }}">
						<div class="fxt-header">
							<div class="fxt-transformY-50 fxt-transition-delay-1">
								<a href="login-13.html" class="fxt-logo"><img src="{{ asset('login_assets/img/logo-13.png') }}" alt="Logo"></a>
							</div>
							<div class="fxt-transformY-50 fxt-transition-delay-2">
								<p>Welcome</p>
							</div>
							<div class="fxt-transformY-50 fxt-transition-delay-3">
								<!-- <p>Grursus mal suada faci lisis Lorem ipsum dolarorit more ametion consectetur elit. Vesti at bulum nec odio aea the dumm ipsumm ipsum that dolocons rsus mal suada and fadolorit to the dummy consectetur elit the Lorem Ipsum genera.</p> -->
							</div>
						</div>
					<!-- 	<ul class="fxt-socials">
							<li class="fxt-facebook fxt-transformY-50 fxt-transition-delay-4"><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
							<li class="fxt-twitter fxt-transformY-50 fxt-transition-delay-5"><a href="#" title="twitter"><i class="fab fa-twitter"></i></a></li>
							<li class="fxt-google fxt-transformY-50 fxt-transition-delay-6"><a href="#" title="google"><i class="fab fa-google-plus-g"></i></a></li>
							<li class="fxt-linkedin fxt-transformY-50 fxt-transition-delay-7"><a href="#" title="linkedin"><i class="fab fa-linkedin-in"></i></a></li>
							<li class="fxt-youtube fxt-transformY-50 fxt-transition-delay-8"><a href="#" title="youtube"><i class="fab fa-youtube"></i></a></li>
						</ul> -->
					</div>
				</div>
				<div class="col-md-6 col-12 order-md-1 fxt-bg-color">
					<div class="fxt-content">
						<h2>Login</h2>
						<div class="fxt-form">
							<form method="POST" action="{{ route('login') }}">
                                @csrf

								<div class="form-group">
									<label for="email" class="input-label">Email Address</label>
									<input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Your Email" required="required" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
								<div class="form-group">
									<label for="password" class="input-label">Password</label>
									<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="" required="required">
									<!-- <i toggle="#password" class="fa fa-fw fa-eye toggle-password field-icon"></i> -->
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
								<div class="form-group">
									<div class="fxt-checkbox-area">
										<div class="checkbox">
											<input id="checkbox1" type="checkbox" name="remember" id="remember" value="{{ old('remember') ? 'checked' : ''}}" >
											<label for="checkbox1">Keep me logged in</label>
										</div>
                                        @if (Route::has('password.request'))
										<a href="{{ route('password.request') }}" class="switcher-text">Forgot Password</a>
                                        @endif 
									</div>
								</div>
								<div class="form-group">
									<button type="submit" class="fxt-btn-fill">Log in</button>
								</div>
							</form>
						</div>
						<div class="fxt-footer">
							<p>Don't have an account?<a href="{{ route('register')}}" class="switcher-text2 inline-text">Register</a></p>

							<a href="{{ asset('login_assets/how-13.html')}}" class="switcher-text2 inline-text">How it works</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- jquery-->
	<script src="{{ asset('login_assets/js/jquery-3.5.0.min.js')}}"></script>
	<!-- Popper js -->
	<script src="{{ asset('login_assets/js/popper.min.js')}}"></script>
	<!-- Bootstrap js -->
	<script src="{{ asset('login_assets/js/bootstrap.min.js')}}"></script>
	<!-- Imagesloaded js -->
	<script src="{{ asset('login_assets/js/imagesloaded.pkgd.min.js')}}"></script>
	<!-- Validator js -->
	<script src="{{ asset('login_assets/js/validator.min.js')}}"></script>
	<!-- Custom Js -->
	<script src="{{ asset('login_assets/js/main.js')}}"></script>

</body>



</html>