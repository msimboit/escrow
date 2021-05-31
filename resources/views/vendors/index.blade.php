@extends('layouts.admin')
@section('content')

<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Vendors</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href=" {{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Vendors</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
      <!-- /.content-header -->
  <section class="content">
    <div class="container-fluid">
        <p>
            <a href="{{ route('addvendor') }}" class="btn btn-primary" disabled>Add New Vendor</a>
        </p>
        <table class="table table-bordered table-striped">
            <tr>
                <th>Escrow Id</th>
                <th>Names </th>
                <th>Phone No </th>
                <th>Email </th>
                <th>ID No. </th>
                <th>Action</th>
            </tr>
            @foreach($vendors as $c)
                <tr>
                    <td>   <a href="{{ route('showvendor',$c->id) }}"> {{ $c->id }}</a></td>
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->phone }}</td>
                    <td>{{ $c->email }}</td>
                    <td>{{ $c->confirm }}</td>
                    <td>
                    <a href="{{ route('editvendor',$c->id) }}" class="btn btn-info">Edit</a> 
                    <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()" class="btn btn-danger">Delete</a>
              <form action="{{ route('deletevendor',$c->id) }}" method="post">
                @method('DELETE')
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
              </form>
            </td>
                </tr>
            @endforeach
        </table>

        {{ $vendors->links() }}
    </div>
  </section>	

  
@endsection
