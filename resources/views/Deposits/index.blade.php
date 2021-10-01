@extends('layouts.admin')
@section('content')

<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Deposits</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href=" {{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Deposits</li>
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
                <th>Buyer Phone Number</th>
                <th>Mpesa Transaction Code</th>
                <th>Amount Paid</th>
                <th>Transaction Details</th>
            </tr>
            @foreach($deposits as $deposit)
                <tr>
                    <td>{{ $deposit->client_phone }}</td>
                    <td>{{ $deposit->transactioncode }}</td>
                    <td>{{ collect(explode(' ',$deposit->transamount))->sum() }}</td>
                    <td>{{ $deposit->transdetail }}</td>
                </tr>
            @endforeach
        </table>
    </div>
  </section>	
@endsection
