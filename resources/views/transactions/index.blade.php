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
        @if(Auth::user()->role == 'vendor')
        <p>
            <a href="{{ route('addtransactions') }}" class="btn btn-primary">Add New Transaction</a>
        </p>
        @endif
       
        <!-- <a id="myID" href="#nada" class="button button-primary">Print container</a> -->
        <table class="table table-bordered table-striped">
            <tr>
                <!-- <th>ID</th> -->
                <!-- <th>Buyer Escrow Id</th>
                <th>Seller Escrow Id</th> -->
                <th>Product </th>
                <th>Amount </th>
                <th>Validated </th>
                <th>Action</th>
            </tr>
            @foreach($transactions as $tr)
                @if(Auth::user()->phone_number == $tr->client_phone || Auth::user()->id == $tr->vendor_id || Auth::user()->role == 'admin' )
                <tr>
                    <!-- <td>{{ $tr->id }}</td> -->
                    <!-- <td>{{ $tr->client_id }}</td>
                    <td>{{ $tr->vendor_id }}</td> -->
                    <td>{{ $tr->transdetail }}</td>
                    <td>{{ collect(explode(' ',$tr->transamount))->sum() }}</td>
                    <td>{{ $tr->validated }}</td>
                    <td>
                      @if(Auth::user()->role === 'admin' || Auth::user()->role === 'vendor')
                      <a href="{{ route('edittransactions',$tr->id) }}" class="btn btn-info">Edit</a>
                      @endif
                      <!-- <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()" class="btn btn-danger">Delete</a>
                      <form action="{{ route('deletetransaction',$tr->id) }}" method="post">
                        @method('DELETE')
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
                        <a href="{{ route('showtransactions',$tr->id) }}" class="btn btn-info">Check</a> 
                      </form>
                    </td>
                </tr>
                @endif
            @endforeach
        </table>
    </div>
    
  </section>	
@endsection
