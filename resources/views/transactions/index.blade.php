@extends('layouts.admin')
@section('content')

<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Transactions</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href=" {{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Transactions</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
      <!-- /.content-header -->
  <section class="content">
    <div class="container-fluid">
        <p>
            <a href="{{ route('addtransactions') }}" class="btn btn-primary">Add New Transaction</a>
        </p>
        <table class="table table-bordered table-striped">
            <tr>
                <th>ID</th>
                <th>Buyer </th>
                <th>Seller </th>
                <th>Product </th>
                <th>Amount </th>
                <th>Validated </th>
                <th>Action</th>
            </tr>
            @foreach($trs as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->client_id }}</td>
                    <td>{{ $c->vendor_id }}</td>
                    <td>{{ $c->transdetail }}</td>
                    <td>{{ $c->transamount }}</td>
                    <td>{{ $c->validated }}</td>
                    <td>
              <a href="{{ route('edittransactions',$c->id) }}" class="btn btn-info">Edit</a> 
              <!-- <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()" class="btn btn-danger">Delete</a>
              <form action="{{ route('deletetransaction',$c->id) }}" method="post">
                @method('DELETE')
                <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
                <a href="{{ route('showtransactions',$c->id) }}" class="btn btn-info">Check</a> 
              </form>
            </td>
                </tr>
            @endforeach
        </table>
    </div>
  </section>	
@endsection
