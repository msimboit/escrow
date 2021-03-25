@extends('layouts.admin')
@section('content')

<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Clients</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href=" {{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Clients</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
      <!-- /.content-header -->
  <section class="content">
    <div class="container-fluid">
        <p>
            <a href="{{ route('addclient') }}" class="btn btn-primary">Add New Client</a>
        </p>
        <table class="table table-bordered table-striped">
            <tr>
                <th>ID</th>
                <th>Names </th>
                <th>Phone No </th>
                <th>Email </th>
                <th>ID No. </th>
                <th>Action</th>
            </tr>
            @foreach($clients as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->firstname }}</td>
                    <td>{{ $c->phoneno }}</td>
                    <td>{{ $c->email }}</td>
                    <td>{{ $c->IdNo }}</td>
                    <td>
              <a href="{{ route('editclient',$c->id) }}" class="btn btn-info">Edit</a> 
              <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()" class="btn btn-danger">Delete</a>
              <form action="{{ route('deleteclient',$c->id) }}" method="post">
                @method('DELETE')
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
              </form>
            </td>
                </tr>
            @endforeach
        </table>
    </div>
  </section>	
@endsection
