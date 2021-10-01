@extends('layouts.admin')
@section('content')

<div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Buyers</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href=" {{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Buyers</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
      <!-- /.content-header -->
  <section class="content">
    <div class="container">
        <!-- <p>
            <a href="{{ route('addclient') }}" class="btn btn-primary">Add New Buyer</a>
        </p> -->
        <table class="table table-bordered table-striped">
            <tr>
                <th>Names </th>
                <th>Phone No </th>
                @if(Auth::user()->role === 'admin')
                <th>Action</th>
                @endif
            </tr>
            @foreach($clients as $c)
                <tr>
                    <td>{{ $c->first_name }} {{ $c->last_name }}</td>
                    <td>{{ $c->phone_number }}</td>
                    @if(Auth::user()->role === 'admin')
                    <td>
                    <a href="{{ route('editUser',$c->id) }}" class="btn btn-success m-2">Edit</a>
                    <a href="{{ route('deleteUser',$c->id) }}" class="btn btn-danger m-2">Delete</a>
                    <a href="{{ route('statements',$c->id) }}" class="btn btn-info m-2">Statements</a>
                    </td>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>
  </section>	
@endsection
