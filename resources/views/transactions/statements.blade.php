@extends('layouts.admin')
@section('content')

<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">All User Transactions</h1>
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
                <th>Paid Amount</th>
                <th>Delivered</th>
                <th>Completed</th>
                <th></th>
            </tr>
            @foreach($transactions as $tr)
                <tr>
                    <td>{{ $tr->id }}</td>
                    <td>{{ $tr->transdetail }}</td>
                    @if($tr->paid == 1)
                    <td>{{ collect(explode(' ',$tr->transamount))->sum() }}</td>
                    @else
                    <td><span class="badge badge-pill badge-primary p-2">PENDING PAYMENT</span></td>
                    @endif
                    @if($tr->delivered == 1)
                    <td><span class="badge badge-pill badge-success p-2">DELIVERED</span></td>
                    @else
                    <td><span class="badge badge-pill badge-primary p-2">PENDING DELIVERY</span></td>
                    @endif
                    @if($tr->closed == 1)
                    <td><span class="badge badge-pill badge-success p-2">YES</span></td>
                    @else
                    <td><span class="badge badge-pill badge-primary p-2">NO</span></td>
                    @endif

                    <td>
                      <a href="{{ route('statementInfo',$tr->id) }}" class="btn btn-info btn-sm">More Info</a>
                    </td>
                </tr>
            @endforeach
        </table>

        {{ $transactions->links() }}
    </div>
  
@endsection
