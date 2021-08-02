@extends('layouts.admin')
@section('content')

<div class="row">
        <div class="col-md-8">
            @if(!empty($search))
            <h2 class="my-6 mx-4">Search Result For:
                <small>{{$search->phone_number}}</small>
            </h2>

            <table class="table table-bordered table-striped table-responsive-md">
            <tr>
                <th>Names </th>
                <th>Phone No </th>
                <th>Email </th>
            </tr>
                <tr>
                    <td>{{ $search->first_name }}</td>
                    <td>{{ $search->phone_number }}</td>
                    <td>{{ $search->email }}</td>
                </tr>
            </table>
            @else
            <h2 class="my-6 mx-4">Search Result Returned:
                <small>No Record Found</small>
            </h2>
            @endif
        </div>
</div>

@endsection