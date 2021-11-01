@extends('layouts.admin')
@section('content')

<div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Disputed Deliveries</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href=" {{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Disputed Deliveries</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
      <!-- /.content-header -->
  <section class="content">
    <div class="container">
        <table class="table table-bordered table-striped">
            <tr>
                <!-- <th>ID</th> -->
                <th>Buyer Name </th>
                <th>Buyer Number </th>
                <th>Transaction Detail</th>
                <th>Action</th>
            </tr>
            @foreach($rejections as $r)
                @if(Auth::user()->phone_number == $r->clientNumber || Auth::user()->phone_number == $r->vendorNumber || Auth::user()->role == 'admin' || Auth::user()->role === 'customer_care' )
                <tr>
                    <td>{{ $r->clientName }}</td>
                    <td>{{ $r->clientNumber }}</td>
                    <td>{{ $r->transdetail }}</td>
                    <td>
                      <a href="{{ route('rejectionInfo', $r->id) }}" class="btn btn-info">More Info</a> 
                    </td>
                </tr>
                @endif
            @endforeach
        </table>
    </div>
  </section>	
@endsection
