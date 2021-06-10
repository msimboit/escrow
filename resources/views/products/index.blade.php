@extends('layouts.admin')
@section('content')

<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Products</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href=" {{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Products</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
      <!-- /.content-header -->
  <section class="content">
    <div class="container-fluid">
        <p>
            <a href="{{ route('addproducts') }}" class="btn btn-primary">Add New Product</a>
        </p>
        <table class="table table-bordered table-striped">
            <tr>
                <th>Product ID</th>
                <th>Names </th>
                <th>Phone Number</th>
                <th>Price </th>
                <th>Action</th>
            </tr>
            @foreach($prds as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->product_name }}</td>
                    <td>{{ $c->phone }}</td>
                    <td>{{ $c->price }}</td>
                    <td>
              <a href="{{ route('editproducts',$c->id) }}" class="btn btn-info" disabled>Edit</a> 
              <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()" class="btn btn-danger" disabled>Delete</a>
              <form action="{{ route('deleteproducts',$c->id) }}" method="post">
                @method('DELETE')
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
              </form>
            </td>
                </tr>
            @endforeach
        </table>

        {{ $prds->links() }}
    </div>
  </section>	
@endsection
