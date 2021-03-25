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
                <th>ID</th>
                <th>Bank </th>
                <th>Branch </th>
                <th>A/C No </th>
                <th>Paybill </th>
                <th>Action</th>
            </tr>
            @foreach($payments as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->bankname }}</td>
                    <td>{{ $c->bankbranch }}</td>
                    <td>{{ $c->accoutnp }}</td>
                    <td>{{ $c->paybill }}</td>
                    <td>
              <a href="{{ route('editpayment',$c->id) }}" class="btn btn-info">Edit</a> 
              <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()" class="btn btn-danger">Delete</a>
              <form action="{{ route('deletepayment',$c->id) }}" method="post">
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
