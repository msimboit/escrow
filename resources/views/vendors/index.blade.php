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
        <div class="card my-4">
                <h5 class="card-header">Search</h5>
                <form class="card-body" action="{{ route('vendorsearch') }}" method="GET" role="search">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for..." name="q">
                        <span class="input-group-btn">
                    <button class="btn btn-secondary" type="submit">Go!</button>
                  </span>
                    </div>
                </form>
        </div>
        <table class="table table-bordered table-striped table-responsive-md">
            <tr>
                <th>Names </th>
                <th>Phone No </th>
                <th>Email </th>
                <th></th>
            </tr>
            @foreach($vendors as $v)
                <tr>
                    <td>{{ $v->first_name }}</td>
                    <td>{{ $v->phone_number }}</td>
                    <td>{{ $v->email }}</td>

                    <td>
                      @if(Auth::user()->role === 'admin')
                      <a href="{{ route('vendorValidate',$v->id) }}" class="btn btn-success m-2">Validate</a>
                      <a href="{{ route('vendorDevalidate',$v->id) }}" class="btn btn-danger m-2">Devalidate</a>
                      <a href="{{ route('editvendor',$v->id) }}" class="btn btn-info m-2">Edit</a>
                      @endif
                    </td>

                </tr>
            @endforeach
        </table>

        <!-- {{ $vendors->links() }} -->
        {{ $vendors->onEachSide(5)->links() }}
    </div>
  </section>	

  
@endsection
