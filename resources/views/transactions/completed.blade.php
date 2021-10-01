@extends('layouts.admin')
@section('content')

<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Completed Transactions</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href=" {{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Completed Transactions</li>
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
                <th>Product </th>
                <th>Amount </th>
                <th>Action</th>
            </tr>
            @foreach($transactions as $tr)
                <tr>
                    <td>{{ $tr->id }}</td>
                    <td>{{ $tr->transdetail }}</td>
                    <td>{{ collect(explode(' ',$tr->transamount))->sum() }}</td>
                    <td>
                        <a href="{{ route('showtransactions',$tr->id) }}" class="btn btn-info">Check</a> 
                      </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    
  </section>	
  
@endsection
