@extends('layouts.admin')
@section('content')

<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Transaction Info</h1>
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
        <table class="table table-bordered table-striped">
            <tr>
                <!-- <th>ID</th> -->
                <th>Order Id</th>
                <th>Order Details</th>
                <th>Goods Amount</th>
                <th>Tariff Charges</th>
                <th>Total Amount</th>
            </tr>
            <tr>
                <td>{{ $transaction->id }}</td>
                <td>{{ $transaction->transdetail }}</td>
                <td>{{ collect(explode(' ',$transaction->transamount))->sum() }}</td>
                <td>{{ $tariff }}</td>
                <td>{{ (collect(explode(' ',$transaction->transamount))->sum())+$tariff}}</td>
            </tr>
        </table>
    </div>
  
@endsection
