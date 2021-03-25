
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
        <h1 class="m-0 text-dark">Bank</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href=" {{ route('abanks') }}">Banks</a></li>
          <li class="breadcrumb-item active">Bank</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<section class="content">
<div class="container-fluid">
  <form method="post" action="{{ route('updateabank',$banking->id) }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
      <div class="row">
        <label class="col-md-3">Bank Name</label>
        <div class="col-md-4"><input type="text" name="bankname" class="form-control" value="{{ $banking->bankname }}" ></div>
        <div class="clearfix"></div>
      </div>
      <div class="row">
        <label class="col-md-3">Bank Branch.</label>
        <div class="col-md-4"><input type="text" name="bankbranch" class="form-control" value="{{ $banking->bankbranch }}"></div>
        <div class="clearfix"></div>
      </div>
      <div class="row">
        <label class="col-md-3">Bank Address.</label>
        <div class="col-md-4"><input type="text" name="bankaddress" class="form-control" value="{{ $banking->bankaddress }}"></div>
        <div class="clearfix"></div>
      </div>

      <div class="row">
        <label class="col-md-3">Contact</label>
        <div class="col-md-4"><input type="text" name="contact" class="form-control" value="{{ $banking->contact }}"></div>
        <div class="clearfix"></div>
      </div>
      
      <div class="row">
        <label class="col-md-3">Email</label>
        <div class="col-md-4"><input type="text" name="email" class="form-control" value="{{ $banking->email }}"></div>
        <div class="clearfix"></div>
      </div>
      <div class="row">
        <label class="col-md-3">Paybill</label>
        <div class="col-md-4"><input type="text" name="paybill" class="form-control" value="{{ $banking->paybill }}"></div>
        <div class="clearfix"></div>
      </div>     
      <div class="row">
        <label class="col-md-3">Account No.</label>
        <div class="col-md-4"><input type="text" name="accountno" class="form-control" value="{{ $banking->accountno }}"></div>
        <div class="clearfix"></div>
      </div>   
      <div class="row">
        <label class="col-md-3">Account Name.</label>
        <div class="col-md-4"><input type="text" name="accountname" class="form-control" value="{{ $banking->accountname }}"></div>
        <div class="clearfix"></div>
      </div>   
      <div class="row">
        <label class="col-md-3">Swift Code</label>
        <div class="col-md-4"><input type="text" name="swiftcode" class="form-control" value="{{ $banking->swiftcode }}"></div>
        <div class="clearfix"></div>
      </div>   
    <div class="form-group">
      <input type="submit" class="btn btn-info" value="Save">
    </div>
  
  </form>
</div>
</section>>

@endsection
