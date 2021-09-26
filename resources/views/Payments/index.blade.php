@extends('layouts.admin')
@section('content')

<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Payments</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href=" {{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Payments</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
      <!-- /.content-header -->
  <section class="content">
    <div class="container-fluid">
        <p>
            <a href="{{ route('addpayment') }}" class="btn btn-primary">Payments</a>
        </p>
        <table class="table table-bordered table-striped">
            <tr>
                <th>Receiver Details</th>
                <th>Mpesa Code</th>
                <th>Amount</th>
            </tr>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->receiver_details }}</td>
                    <td>{{ $payment->mpesacode }}</td>
                    <td>{{ $payment->amount }}</td>
                </tr>
            @endforeach
        </table>
    </div>
  </section>	
@endsection
