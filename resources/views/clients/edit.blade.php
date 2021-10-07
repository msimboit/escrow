
@extends('layouts.admin')
@section('content')

<style>
  #map {
    height: 400px;
    width: 100%;
  }
</style>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Edit Client</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href=" {{ route('clients') }}">Clients</a></li>
          <li class="breadcrumb-item active">Edit Client</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<section class="content">
<div class="container-fluid">
  <form method="post" action="{{ route('updateclient',$client->id) }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
      <div class="row">
        <label class="col-md-3">First Name</label>
        <div class="col-md-4"><input type="text" name="firstname" class="form-control" value="{{ $client->firstname }}" ></div>
        <div class="clearfix"></div>
      </div>
      <div class="row">
        <label class="col-md-3">Middle Name</label>
        <div class="col-md-4"><input type="text" name="middlename" class="form-control" value="{{ $client->firstname }}" ></div>
        <div class="clearfix"></div>
      </div>
      <div class="row">
        <label class="col-md-3">Last Name</label>
        <div class="col-md-4"><input type="text" name="lastname" class="form-control" value="{{ $client->firstname }}" ></div>
        <div class="clearfix"></div>
      </div>
      <div class="row">
        <label class="col-md-3">ID No.</label>
        <div class="col-md-4"><input type="text" name="idno" class="form-control"  value="{{ $client->IdNo }}" ></div>
        <div class="clearfix"></div>
      </div>
      <div class="row">
        <label class="col-md-3">Country</label>
        <div class="col-md-4"><input type="text" name="country" class="form-control"  value="{{ $client->country }}" ></div>
        <div class="clearfix"></div>
      </div>
      
      <div class="row">
        <label class="col-md-3">Email</label>
        <div class="col-md-4"><input type="text" name="email" class="form-control"  value="{{ $client->email }}" ></div>
        <div class="clearfix"></div>
      </div>
      <div class="row">
        <label class="col-md-3">Phone</label>
        <div class="col-md-4"><input type="text" name="phoneno" class="form-control"  value="{{ $client->phoneno }}" ></div>
        <div class="clearfix"></div>
      </div>  
      <div class="row">
        <label class="col-md-3">Password</label>
        <div class="col-md-4"><input type="text" name="password" class="form-control"  value="{{ $client->phoneno }}" ></div>
        <div class="clearfix"></div>
      </div>  

    <div class="form-group">
      <input type="submit" class="btn btn-info" value="Update">
    </div>
  
  </form>
</div>
</section>

@endsection
