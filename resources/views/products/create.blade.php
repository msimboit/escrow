
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
        <h1 class="m-0 text-dark">Add Product</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href=" {{ route('products') }}">Products</a></li>
          <li class="breadcrumb-item active">Add Product</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<section class="content">
<div class="container-fluid">
  <form method="post" action="{{ route('storeproducts') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
      <div class="row">
        <label class="col-md-3">Product Name</label>
        <div class="col-md-4"><input type="text" name="productname" class="form-control"></div>
        <div class="clearfix"></div>
      </div>
      <div class="row">
        <label class="col-md-3">Price.</label>
        <div class="col-md-4"><input type="text" name="price" class="form-control"></div>
        <div class="clearfix"></div>
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

