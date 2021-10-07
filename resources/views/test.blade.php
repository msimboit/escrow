@extends('layouts.admin')
@section('content')



  <!-- Content Wrapper. Contains page content -->
  <!-- <div class="content-wrapper"> -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/home">Home</a></li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row d-flex justify-content-center">
          <!-- /.col -->
          <div class="col-md-8">
            <div class="card">
              <div class="card-header p-2">
              <h3 class="profile-username text-center">Edit User Profile</h3>
                
                @if(Auth::user()->role == 'vendor')
                <p class="text-muted text-center">Vendor</p>
                @endif

                @if(Auth::user()->role == 'client')
                <p class="text-muted text-center">Buyer</p>
                @endif
                <!-- <ul class="nav nav-pills"> -->
                  <!-- <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li> -->
                  <!-- <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Details</a></li> -->
                <!-- </ul> -->
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="settings">
                    <form class="form-horizontal" action="{{ route('updateUser') }}" method="POST">
						@csrf
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">First Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="first_name" id="inputName" value="{{ $user->first_name}}">
                        </div>
                      </div>

					  <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Middle Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="middle_name" id="inputName" value="{{ $user->middle_name}}">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Last Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="last_name" id="inputName" value="{{ $user->last_name}}">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" name="email" id="inputEmail" value="{{ $user->email}}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="phone_number" id="inputName2" value="{{ $user->phone_number}}">
                        </div>
                      </div>

					  <div class="form-group row">
						<label for="role" class="col-sm-2 col-form-label">{{ __('Role') }}</label>

						<div class="col-md-6">
						<select class="form-control" name="role" id="role" value="{{ $user->role}}" required>
							<option value="vendor">Vendor</option>
							<option value="client">Buyer</option>
						</select>
						</div>
					  </div>
					  @if($user->business_name != null)
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Business Name</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName2" name="business_name" value="{{ $user->business_name}}">
                        </div>
                      </div>
					  @else
					  <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Business Name</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName2" name="business_name" value="">
                        </div>
                      </div>
					  @endif
            <div class="form-group row">
              <label for="inputName" class="col-sm-2 col-form-label">Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" name="password" id="password" required>
              </div>
            </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Edit Profile</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  <!-- </div> -->
  <!-- /.content-wrapper -->



@endsection