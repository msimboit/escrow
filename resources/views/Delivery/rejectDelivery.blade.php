@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between"><span>{{ __('Reason For Rejecting The Delivery') }}</span>  <span>{{ \Carbon\Carbon::now()->toDateString() }}</span></div>

                <div class="card-body">
                    {{__('Hello')}}
                    {{ Auth::user()->first_name }},
                    <br />
                    <br />
                    {{ __('Give The Reason For Rejection Below:') }}
                    <br />
                    <br />
                    
                    <form action="{{ route('rejectDelivery') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @if ($errors->any())
                        <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        </div>
                        @endif

                        <div class="form-group">
                            <label for="title">Rejection Title:</label>
                            <input type="text" name="title" value="{{ old('title') }}" class="form-control" placeholder="Title">
                        </div>

                        <div class="form-group">
                            <label for="details">Rejection Details:</label>
                            <textarea name="details" value="{{ old('details') }}" class="form-control" placeholder="Details"></textarea>
                        </div>

                        <input type="text" name="clientName" value="{{ $trans_details['clientName'] }}" hidden>
                        <input type="text" name="clientNumber" value="{{ $trans_details['clientNumber'] }}" hidden>
                        <input type="text" name="clientEmail" value="{{ $trans_details['clientEmail'] }}" hidden>
                        <input type="text" name="vendorName" value="{{ $trans_details['vendorName'] }}" hidden>
                        <input type="text" name="vendorNumber" value="{{ $trans_details['vendorNumber'] }}" hidden>
                        <input type="text" name="vendorEmail" value="{{ $trans_details['vendorEmail'] }}" hidden>
                        <input type="text" name="orderId" value="{{ $trans_details['orderId'] }} "hidden>
                        <input type="text" name="orderdate" value="{{ $trans_details['orderdate'] }}" hidden>
                        <input type="text" name="transdetail" value="{{ $trans_details['transdetail'] }}" hidden>
                        <input type="text" name="quantity" value="{{ $trans_details['quantity'] }}" hidden>
                        <input type="text" name="subtotal" value="{{ $trans_details['subtotal'] }}" hidden>
                        <input type="text" name="tariff" value="{{ $trans_details['tariff'] }}" hidden>
                        <input type="text" name="total" value="{{ $trans_details['total'] }}" hidden>
                        <input type="text" name="deliveryfee" value="{{ $trans_details['deliveryfee'] }}" hidden>

                        <div class="form-group">
                            <input type="submit" value="{{ __('Report Issue') }}" class="btn btn-success">
                        </div>

                    </form>

                    <div class="my-3">
                        <button class="btn btn-secondary">
                            <a href="{{ route('showdelivery', $trans_details['orderId']) }}" style="text-decoration:none; color:#fff">Go Back</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
