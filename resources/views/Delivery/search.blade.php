@extends('layouts.admin')
@section('content')

<div class="row">
        <div class="col-md-8">

            @if($search == null || $search == '')
            <h2>No Deliveries Found</h2>
            @else
            <h2 class="my-6 mx-4">Search Result For:
                <small>{{$search[0]->client_phone}}</small>
            </h2>

            <table class="table table-bordered table-striped">
            <tr>
                <!-- <th>ID</th> -->
                <th>Buyer Name </th>
                <th>Buyer Number </th>
                <th>Transaction Detail</th>
                <th>Mpesa Code</th>
                <th>Action</th>
            </tr>
            @foreach($search as $s)
            <tr>
                    <!-- <td>{{ $s->id }}</td> -->
                    <td>{{ \App\User::where('id', $s->client_id)->pluck('first_name')->first() }}</td>
                    <td>{{ \App\User::where('id', $s->client_id)->pluck('phone_number')->first() }}</td>
                    <td>{{ $s->transdetail }}</td>
                    <td>N/A</td>
                    <td>
              <a href="{{ route('showdelivery',$s->id) }}" class="btn btn-info">Sale Order</a> 
            </td>
                </tr>
            @endforeach
        </table>
        @endif
        </div>
</div>

@endsection