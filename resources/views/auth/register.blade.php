<!doctype html>
<html class="no-js" lang="">



<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>SupamallEscrow</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('login_assets/img/favicon.png')}}">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ asset('login_assets/css/bootstrap.min.css')}}">
	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="{{ asset('login_assets/css/fontawesome-all.min.css')}}">
	<!-- Flaticon CSS -->
	<link rel="stylesheet" href="{{ asset('login_assets/font/flaticon.css')}}">
	<!-- Google Web Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap" rel="stylesheet">
	<!-- Custom CSS -->
	<link rel="stylesheet" href="{{ asset('login_assets/style.css')}}">

    <script src="{{ asset('js/register_modal.js') }}" defer></script>

</head>

<body>
	<!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
	<div id="wrapper" class="wrapper">
		<div class="fxt-template-animation fxt-template-layout13">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-6 col-12 order-md-2 fxt-bg-wrap">
						<div class="fxt-bg-img" data-bg-image="{{ asset('login_assets/img/figure/bg13-l.jpg')}}">
							<div class="fxt-header">
								<div class="fxt-transformY-50 fxt-transition-delay-1">
									<a href="login-13.html" class="fxt-logo"><img src="{{ asset('login_assets/img/logo-13.png')}}" alt="Logo"></a>
								</div>
								<div class="fxt-transformY-50 fxt-transition-delay-2">
									<p>Welcome</p>
								</div>
							<!-- 	<div class="fxt-transformY-50 fxt-transition-delay-3">
									<p>Grursus mal suada faci lisis Lorem ipsum dolarorit more ametion consectetur elit. Vesti at bulum nec odio aea the dumm ipsumm ipsum that dolocons rsus mal suada and fadolorit to the dummy consectetur elit the Lorem Ipsum genera.</p>
								</div> -->
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
							<h2>Register</h2>
							<div class="fxt-form">
								<form method="POST" action="{{ route('register') }}">
                                    @csrf

									<div class="form-group">
										<label for="first_name" class="input-label">First Name</label>
										<input type="text" id="first_name" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" placeholder="first name" required="required" autofocus>
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
										<label for="middle_name" class="input-label">Middle Name</label>
										<input type="text" id="middle_name" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" placeholder="middle name" value="{{ old('middle_name') }}">
                                        @error('middle_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
									<div class="form-group">
										<label for="last_name" class="input-label">Last Name</label>
										<input type="text" id="last_name" class="form-control @error('last_name') is-invalid @enderror" name="last_name" placeholder="last name" value="{{ old('last_name') }}" required="required">
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
									</div>
                                    <div class="form-group">
										<label for="phone_number" class="input-label">Phone Number</label>
										<input type="text" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" placeholder="phone number" required="required">
                                        @error('phone_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                            <label for="role" class="input-label">Select Role:</label>
                            <select class="form-control" name="role" id="change">
                                <option>Select role</option>
                                <option value="vendor" data-toggle="modal" data-target="#myModal"> 
                                    Vendor
                                </option>
                                <option value="client" > 
                                    Buyer
                                </option>
                            </select>
                        </div>

                        <div class="modal hide fade in" data-backdrop="false" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="d-flex justify-content-end m-2">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-header">
                                        <h4 class="modal-title">Modal title</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group row">
                                            <label for="business_name" class="col-md-4 col-form-label text-md-right">{{ __('Business Name') }}</label>

                                            <div class="col-md-6">
                                                <input id="modal_business_name" type="text" class="form-control" name="modal_business_name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger sm" data-dismiss="modal" id="modal_save">Save</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                            
									<div class="form-group">
										<label for="email" class="input-label">Email Address</label>
										<input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="email" value="{{ old('email') }}" required="required">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
									<div class="form-group">
										<label for="password" class="input-label">Password (or PIN)</label>
										<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="" required="required" autocomplete="new-password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
									</div>
									<div class="form-group">
										<label for="password-confirm" class="input-label">Confirm Password (or PIN)</label>
										<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required="required" autocomplete="new-password">
									</div>

                                    <div class="col-md-6 offset-md-4 mb-2">
                                        {!! NoCaptcha::display() !!}
                                    </div>
									<div class="form-group">
										<div class="fxt-checkbox-area">
											<div class="checkbox">
												<input id="checkbox1" type="checkbox" class="number" value="One" required>
												<label for="checkbox1"><a href="/terms and faqs/terms.html">I agree with the terms and condition</a></label>
											</div>
										</div>
									</div>

                                    <input id="business_name" type="text" class="form-control" name="business_name" hidden>
									
                                    <div class="form-group">
										<button type="submit" class="fxt-btn-fill" id="reg" disabled>Register</button>
									</div>
								</form>
							</div>
							<div class="text-center">
								<p>Have an account?<a href="{{ route('login')}}" class="switcher-text2 inline-text">Log in</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
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