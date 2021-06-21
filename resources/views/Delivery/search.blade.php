@extends('layouts.admin')
@section('content')

<div class="row">
        <div class="col-md-8">

            <h2 class="my-6 mx-4">Search Result For:
                <small>{{$search[0]->client_phone}}</small>
            </h2>

            <table class="table table-bordered table-striped">
            <tr>
                <!-- <th>ID</th> -->
                <th>Client Name </th>
                <th>Client No </th>
                <th>Client Email</th>
                <th>Transaction Detail</th>
                <th>Mpesa Code</th>
                <th>Action</th>
            </tr>
            @foreach($search as $s)
                <tr>
                    <!-- <td>{{ $s->id }}</td> -->
                    <td>{{ \App\Clients::where('id', $s->client_id)->pluck('firstname')->first() }}</td>
                    <td>{{ \App\Clients::where(['id' => $s->client_id])->pluck('phoneno')->first() }}</td>
                    <td>{{ \App\Clients::where(['id' => $s->client_id])->pluck('email')->first() }}</td>
                    <td>{{ $s->transdetail }}</td>
                    <td>N/A</td>
                    <td>
              <a href="{{ route('showdelivery',$s->id) }}" class="btn btn-info">Sale Order</a> 
            </td>
                </tr>
            @endforeach
        </table>
        </div>
</div>

@endsection