@extends('layouts.admin')
@section('content')

<div class="content-header">
    <div class="container">
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
    <div class="container">
        <!-- @if(Auth::user()->role == 'vendor' && Auth::user()->validated == 1)
        <p>
            <a href="{{ route('addtransactions') }}" class="btn btn-primary">Add New Transaction</a>
        </p>
        @endif

        @if(Auth::user()->role == 'vendor' && Auth::user()->validated == 0)
        <p>
            <span>Your Account is Pending Verification.
            <i>Contact customer care for more info</i></span>
            <a href="#" class="btn btn-primary" disabled>Add New Transaction</a>
        </p>
        @endif -->

        @if(Auth::user()->role == 'vendor' || Auth::user()->role == 'admin')
        <a href="{{ route('addtransactions') }}" class="btn btn-primary">Add New Transaction</a>
        @endif
       
        <!-- <a id="myID" href="#nada" class="button button-primary">Print container</a> -->
        <table class="table table-bordered table-striped">
            <tr>
                <!-- <th>ID</th> -->
                <th>Order Id</th>
                <th>Product </th>
                <th>Amount </th>
                <th>Paid For</th>
                <th>Action</th>
            </tr>
            @foreach($transactions as $tr)
                @if(Auth::user()->phone_number == $tr->client_phone || Auth::user()->id == $tr->vendor_id || Auth::user()->role == 'admin' )
                <tr>
                    <td>{{ $tr->id }}</td>
                    <td>{{ $tr->transdetail }}</td>
                    <td>{{ collect(explode(' ',$tr->transamount))->sum() }}</td>
                    <td><span class="badge badge-pill badge-primary p-2">PENDING</span></td>
                    <td>
                      @if(Auth::user()->role === 'admin' || Auth::user()->role === 'vendor')
                      <a href="{{ route('edittransactions',$tr->id) }}" class="btn btn-info m-2">Edit</a>
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
