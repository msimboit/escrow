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
              <h3 class="profile-username text-center">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h3>
                
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
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">First Name</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputName" placeholder="{{Auth::user()->first_name}}" readonly>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Last Name</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputName" placeholder="{{Auth::user()->last_name}}" readonly>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputEmail" placeholder="{{Auth::user()->email}}" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName2" placeholder="{{Auth::user()->phone_number}}" readonly>
                        </div>
                      </div>
                      @if(Auth::user()->role == 'vendor')
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Business Name</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName2" placeholder="{{Auth::user()->business_name}}" readonly>
                        </div>
                      </div>
                      @endif
            
                      <!-- <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Edit Profile</button>
                        </div>
                      </div> -->
                      @if (Auth::user()->role =='client' || Auth::user()->role == 'vendor')
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                        <button type="button" class="btn btn-info btn" data-toggle="modal" data-target="#password-modal">Change Password</button>
                        </div>
                      </div>
                      @endif

                      <div id="password-modal" class="modal hide fade in" data-backdrop="false" tabindex="-1" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h3>Change Your Password</h3>
                            </div>
                            <form method="POST" action="{{ route('changePassword') }}" id="contactForm" name="contact" role="form">
                              @csrf
                              <div class="modal-body">				
                                <div class="form-group">
                                  <label for="old_password">Old Password(Or One-Time-Password)</label>
                                  <input type="text" name="old_password" class="form-control">
                                </div>
                                <div class="form-group">
                                  <label for="new_password">New Password</label>
                                  <input type="password" name="new_password" class="form-control" required>
                                </div>			
                              </div>
                              <div class="modal-footer">					
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-success" id="submit">
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    
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