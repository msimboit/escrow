@component('mail::message')
# An Escrow Transaction Was Created By You.

The transaction was made successfully for:
<br/>
<b>Buyer Name:</b> {{ $data['client_name']}}
<br/>
<br/>
<b>Buyer Phone Number:</b> {{ $data['client_phone']}}
<br/>
<br/>
<b>Item Descriptions:</b> {{ $data['itemdesc']}}
<br/>
<br/>
<b>Prices:</b> {{ $data['prices']}}
<br/>
<br/>
<b>location:</b> {{ $data['location']}}
<br/>
<br/>
<b>Delivered In:</b> {{ $data['delivery_time']}}hrs
<br/>
<br/>
<b>Delivery Fee:</b> {{ $data['delivery_fee']}}
<br/>
<br/>
<b>Delivery Fee To Be Handled By:</b> @if($data['delivery_fee_handler'] == 'client')Buyer @else Vendor @endif
<br/>


@component('mail::button', ['url' => 'https://phplaravel-607367-1966954.cloudwaysapps.com/home'])
Go Back To Escrow
@endcomponent

Thanks,<br>
{{ config('app.name') }}
<small>By MsimboIT</small>
@endcomponent
