
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
        <h1 class="m-0 text-dark">Edit Vendor</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href=" {{ route('vendors') }}">Vendors</a></li>
          <li class="breadcrumb-item active">Edit Vendor</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<section class="content">
<div class="container-fluid">
  <form method="post" action="{{ route('updatevendor',$vend->id) }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
      <div class="row">
        <label class="col-md-3">Vendor Name</label>
        <div class="col-md-4"><input type="text" name="firstname" class="form-control" value="{{ $vend->firstname }}" ></div>
        <div class="clearfix"></div>
      </div>
      <div class="row">
        <label class="col-md-3">ID No.</label>
        <div class="col-md-4"><input type="text" name="idno" class="form-control"  value="{{ $vend->IdNo }}" ></div>
        <div class="clearfix"></div>
      </div>
      <div class="row">
        <label class="col-md-3">Country</label>
        <div class="col-md-4"><input type="text" name="country" class="form-control"  value="{{ $vend->country }}" ></div>
        <div class="clearfix"></div>
      </div>
      
      <div class="row">
        <label class="col-md-3">Email</label>
        <div class="col-md-4"><input type="text" name="email" class="form-control"  value="{{ $vend->email }}" ></div>
        <div class="clearfix"></div>
      </div>
      <div class="row">
        <label class="col-md-3">Phone</label>
        <div class="col-md-4"><input type="text" name="phoneno" class="form-control"  value="{{ $vend->phoneno }}" ></div>
        <div class="clearfix"></div>
      </div>     

    <div class="form-group">
      <input type="submit" class="btn btn-info" value="Update">
    </div>
  
  </form>
</div>
</section>>

@endsection
