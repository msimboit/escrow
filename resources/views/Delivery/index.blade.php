@extends('layouts.admin')
@section('content')

<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Deliveries</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href=" {{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Deliveries</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
      <!-- /.content-header -->
  <section class="content">
    <div class="container-fluid">
        <!-- <p>
            <a href="{{ route('adddelivery') }}" class="btn btn-primary">Add Delivery</a>
        </p> -->
        <table class="table table-bordered table-striped">
            <tr>
                <th>ID</th>
                <th>Client Name </th>
                <th>Client No </th>
                <th>Client Email</th>
                <th>Transaction Detail</th>
                <th>Mpesa Code</th>
                <th>Action</th>
            </tr>
            @foreach($deliveries as $d)
                <tr>
                    <td>{{ $d->id }}</td>
                    <td>{{ \App\Clients::where('id', $d->client_id)->pluck('firstname')->first() }}</td>
                    <td>{{ \App\Clients::where(['id' => $d->client_id])->pluck('phoneno')->first() }}</td>
                    <td>{{ \App\Clients::where(['id' => $d->client_id])->pluck('email')->first() }}</td>
                    <td>{{ $d->transdetail }}</td>
                    <td>N/A</td>
                    <td>
              <a href="{{ route('showdelivery',$d->id) }}" class="btn btn-info">Sale Order</a> 
<!-- 
              <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()" class="btn btn-danger">Delete</a>
              <form action="{{ route('deletedelviery',$d->id) }}" method="post">
                @method('DELETE')
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
              </form> -->
            </td>
                </tr>
            @endforeach
        </table>
    </div>
  </section>	
@endsection
