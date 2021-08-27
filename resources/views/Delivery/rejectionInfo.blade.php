@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card mt-3">
                <div class="card-header d-flex justify-content-between"><span>{{ __('Report Info') }}</span>  <span>{{ \Carbon\Carbon::now()->toDateString() }}</span></div>

                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        {{__('Hello')}}
                        {{ Auth::user()->first_name }},
                    </div>
                    <h3>{{ __('Report Number:') }} {{ $rejection->id }}</h3>
                    <h4>{{ __('Transaction ID:') }} {{ $rejection->orderId }}</h4>
                    <hr>
                    <h4>Title: {{ $rejection->title }}</h3>
                    <h5>Created By: {{ $rejection->clientName }}</h5>
                    <h5>Created At: {{ $rejection->created_at }}</h5>
                    <div class="my-5">
                        <p>Reason for rejection:    {{ $rejection->details }}</p>
                        <p>Transaction detail in question:   {{ $rejection->transdetail }}</p>
                    </div>

                    @if(Auth::user()->role == 'admin')
                    <button class="btn btn-success sm">
                        <a href=" {{ route('clearRejection', $rejection->id) }} " style="text-decoration:none; color:#fff">Clear The Issue</a>
                    </button>
                    @endif
                </div> 

                <div class="my-3 ml-3">
                    <button class="btn btn-secondary">
                        <a href="{{ route('rejections') }} " style="text-decoration:none; color:#fff">Back To Disputes</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
