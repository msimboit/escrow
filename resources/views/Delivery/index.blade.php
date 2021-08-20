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
        @if(Auth::user()->role == 'vendor' || Auth::user()->role == 'admin')
        <div class="card my-4">
            <h5 class="card-header">Search</h5>
            <form class="card-body" action="/deliveries/search" method="GET" role="search">
                {{ csrf_field() }}
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for 070012345678" name="q">
                    <span class="input-group-btn">
                <button class="btn btn-secondary" type="submit">Go!</button>
              </span>
                </div>
            </form>
        </div>
        @endif
        <table class="table table-bordered table-striped">
            <tr>
                <!-- <th>ID</th> -->
                <th>Client Name </th>
                <th>Client Number </th>
                <th>Transaction Detail</th>
                <th>Action</th>
            </tr>
            @foreach($deliveries as $d)
                @if(Auth::user()->id == $d->client_id || Auth::user()->id == $d->vendor_id || Auth::user()->role == 'admin' )
                <tr>
                    <td>{{ \App\User::where('id', $d->client_id)->pluck('first_name')->first() }}</td>
                    <td>{{ \App\User::where('id', $d->client_id)->pluck('phone_number')->first() }}</td>
                    <td>{{ \App\User::where('id', $d->client_id)->pluck('email')->first() }}</td>
                    <td>{{ $d->transdetail }}</td>
                    <td>
                      <a href="{{ route('showdelivery',$d->id) }}" class="btn btn-info">Sale Order</a> 
                    </td>
                </tr>
                @endif
            @endforeach
        </table>
    </div>
  </section>	
@endsection
