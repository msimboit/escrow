
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
        <h1 class="m-0 text-dark">Edit Product</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href=" {{ route('products') }}">Products</a></li>
          <li class="breadcrumb-item active">Edit Product</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<section class="content">
<div class="container-fluid">
  <form method="post" action="{{ route('updateproducts', $prod->id) }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
      <div class="row">
        <label class="col-md-3">Product Name</label>
        <div class="col-md-4"><input type="text" name="productname" class="form-control" value="{{ $prod->name }}" ></div>
        <div class="clearfix"></div>
      </div>
      <div class="row">
        <label class="col-md-3">Product Price</label>
        <div class="col-md-4"><input type="text" name="productprice" class="form-control"  value="{{ $prod->price }}" ></div>
        <div class="clearfix"></div>
      </div>

    <div class="form-group">
      <input type="submit" class="btn btn-info" value="Update">
    </div>
  
  </form>
</div>
</section>

@endsection
