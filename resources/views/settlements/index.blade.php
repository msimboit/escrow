@extends('layouts.admin')
@section('content')

<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Settlements</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href=" {{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Settlements</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
      <!-- /.content-header -->
  <section class="content">
    <div class="container-fluid">
        <p>
            <a href="{{ route('addsettlement') }}" class="btn btn-primary">Add Settlements</a>
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
            @foreach($settlements as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->bankname }}</td>
                    <td>{{ $c->bankbranch }}</td>
                    <td>{{ $c->accoutnp }}</td>
                    <td>{{ $c->paybill }}</td>
                    <td>
              <a href="{{ route('editsettlement',$c->id) }}" class="btn btn-info">Edit</a> 
              <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()" class="btn btn-danger">Delete</a>
              <form action="{{ route('deletesettlement',$c->id) }}" method="post">
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
