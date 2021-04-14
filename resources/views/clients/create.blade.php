
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
        <h1 class="m-0 text-dark">Add Client</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href=" {{ route('clients') }}">Clients</a></li>
          <li class="breadcrumb-item active">Add Cient</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<section class="content">
<div class="container-fluid">
  <form method="post" action="{{ route('storeclient') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
      <div class="row">
        <label class="col-md-3">Client Name</label>
        <div class="col-md-4"><input type="text" name="clientname" class="form-control"></div>
        <div class="clearfix"></div>
      </div>
      <div class="row">
        <label class="col-md-3">ID No.</label>
        <div class="col-md-4"><input type="text" name="idno" class="form-control"></div>
        <div class="clearfix"></div>
      </div>
      <div class="row">
        <label class="col-md-3">Country</label>
        <div class="col-md-4"><input type="text" name="country" class="form-control"></div>
        <div class="clearfix"></div>
      </div>
      
      <div class="row">
        <label class="col-md-3">Email</label>
        <div class="col-md-4"><input type="text" name="email" class="form-control"></div>
        <div class="clearfix"></div>
      </div>
      <div class="row">
        <label class="col-md-3">Phone</label>
        <div class="col-md-4"><input type="text" name="phoneno" class="form-control"></div>
        <div class="clearfix"></div>
      </div>     
      <div class="row p-2">
        <label class="col-md-3 p-2">Terms & Conditions</label>
        <div class="col-md-4"><input type="checkbox" name="acceptedtnc" class="form-control"></div>
        <div class="clearfix"></div>
      </div>   

      <div class="form-group">
        <label for="address_address">Physical Address</label>
        <input type="text" id="address-input" name="address_address" class="form-control map-input">
        <input type="hidden" name="address_latitude" id="address-latitude" value="0" />
        <input type="hidden" name="address_longitude" id="address-longitude" value="0" />
      </div>
      <div class="row">
      <div id="address-map-container" style="width:100%;height:200px; ">
          <div style="width: 100%; height: 100%" id="address-map"></div>
      </div>
    </div>

    <div class="form-group">
      <input type="submit" class="btn btn-info" value="Save">
    </div>
  
  </form>
  

</div>
</section>

@section('scripts')
    @parent
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize" async defer></script>
    <script src="/js/mapInput.js"></script>
@stop
@endsection

