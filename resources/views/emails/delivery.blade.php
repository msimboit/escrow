@component('mail::message')
# A delivery was accepted using Escrow.

You have accepted the delivery for:
<br/>
<b>Buyer Name:</b> {{ $data['client_name']}}
<br/>
<br/>
<b>Buyer Phone Number:</b> {{ $data['client_phone']}}
<br/>
<br/>
<b>Transaction Details:</b> {{ $data['transaction_details']}}
<br/>
<br/>
<b>Delivered At:</b> {{ $data['delivery_location']}}
<br/>
<br/>
<b>Delivery Fee:</b> {{ $data['delivery_fee']}}
<br/>
<br/>
<b>Delivery Fee Handled By:</b> @if($data['delivery_fee_handler'] == 'client')Buyer @else Vendor @endif
<br/>


@component('mail::button', ['url' => 'https://phplaravel-607367-1966954.cloudwaysapps.com/home'])
Go Back To Escrow
@endcomponent

Thanks,<br>
{{ config('app.name') }}
<br/>
<small>By MsimboIT</small>
@endcomponent
