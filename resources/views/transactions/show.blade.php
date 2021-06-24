@extends('layouts.admin')
@section('content')

<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Transactions</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href=" {{ route('transactions') }}">Transactions</a></li>
            <li class="breadcrumb-item active">Transactions</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
      <!-- /.content-header -->

  <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="callout callout-info hidden-print">
              <h5><i class="fas fa-info"></i> Note:</h5>
              This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
            </div>


            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> Sale/Purchase Order
                    <small class="float-right">Date: {{ $arr->created_at->format('d/m/Y H:i:s') }}</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                <strong><u>Vendor Details</u></strong>
                  <address>
                    Name: <strong>{{ $vdetails->username }}</strong><br>
                    Phone: {{ $vdetails->phone }}<br>
                    Email: {{$vdetails->email }}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <strong><u>Buyer Details</u></strong> 
                  <address>
                    Name: <strong>{{ $cdetails->firstname }}</strong><br>
                    Phone: {{ $cdetails->phoneno }}<br>
                    Email: {{ $cdetails->email }}<br>
                    Location: {{$cdetails->country }}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <strong><u>Order Details</u></strong><br>
                  <b>Order No:</b> {{$arr->id}}<br>
                  <b>Payment Due:</b> {{ $arr->created_at->format('d-m-Y')}}<br>
                  <b>Account:</b> 968-34567<br>
                  <b>Delivery Point:</b> {{ $arr->deliverylocation }}
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row mt-4">
                <div class="col-12 table-responsive">
                  <table class="table table-hover">
                    <thead>
                    <tr>
                      <th class="text-center"  scope="col">Descriptions</th>
                      <th class="text-center" scope="col">Quantity</th>
                      <th class="text-center" scope="col">Amount</th>
                      <th class="text-center" scope="col">Images</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td class="text-center">
                          @foreach ($itemdesc as $desc)
                           {{ $desc }}<br/><br/><br/><br/><br />
                          @endforeach
                      </td>
                      <td class="text-center">
                          @foreach ($quantities as $quantity)
                            {{ $quantity }}<br/><br/><br/><br/><br />
                          @endforeach
                      </td>
                      <td class="text-center">
                          @foreach ($prices as $price)
                            {{ $price }}<br/><br/><br/><br/><br />
                          @endforeach
                      </td>
                      <td class="text-center" style="width: 100px; height: 100px;">
                          @foreach ($product_image as $image)
                            <img 
                                  src=" {{ asset('product_images/' .$image) }}" 
                                  class="img-fluid max-width: 100%; height: auto;"
                                  alt="">
                            
                          @endforeach
                        </td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-5 p-3 display:flex; align-items:space-between;">
                  <p class="lead">Payment Methods:</p>
                  <h5 style="margin: 5px; font-weight: bold;">MPESA:</h5>
                  <p class="text-muted well well-sm shadow-none" style="margin: 5px;">
                    PayBill Number: 174955
                  </p>

                  <h5 style="margin: 5px; font-weight: bold;">Additional Payment Options:</h5>
                  <p class="text-muted well well-sm shadow-none" style="margin: 5px;">
                    Till Number: 174955
                  </p>
                </div>
                <!-- /.col -->
                <div class="col-6 p-2">
                  <p class="lead">Amount Due on {{ $arr->created_at->format('d-m-Y')}}</p>

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>Kshs.{{ array_sum($prices) }}</td>
                      </tr>
                      <tr>
                        <th>Handling Fee(1%)</th>
                        <td>Kshs.{{ round(((array_sum($prices))/100)*1) }}.00</td>
                      </tr>
                      <tr>
                        <th>Delivery Fee:</th>
                        <td>{{ $arr->deliveryamount }}</td>
                      </tr>
                      <tr>
                        <th>Delivery Fee <br /> Handled By:</th>
                        <td>
                        <input type="checkbox" id="deliveryfee" value="deliveryfee" onclick="myFunction()"> <small> Agree that Vendor handles delivery fee</small> </input>
                        <p id="text" style="display:none"><small>*Vendor will be <strong>charged!</strong></small></p>
                        </td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>Kshs.{{ (array_sum($prices)) + (((array_sum($prices))/100)*1) + 1050 }}</td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <button type="button" class="btn btn-primary float-left" style="margin-right: 5px;" id="lnkPrint">
                    <i class="fas fa-print"></i> Print
                  </button>
                  <form action="{{ route('transactionpayment') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="clientName" value="{{ $cdetails->firstname }}" hidden>
                    <input type="text" name="clientNumber" value="{{ $cdetails->phoneno }}" hidden>
                    <input type="text" name="clientEmail" value="{{ $cdetails->email }}" hidden>
                    <input type="text" name="vendorName" value="{{ $vdetails->username }}" hidden>
                    <input type="text" name="vendorNumber" value="{{ $vdetails->phone }}" hidden>
                    <input type="text" name="vendorEmail" value="{{ $vdetails->email }}" hidden>
                    <input type="text" name="orderId" value="{{ $arr->id }} "hidden>
                    <input type="text" name="orderdate" value="{{ $arr->created_at->format('d-m-Y') }}" hidden>
                    <input type="text" name="transdetail" value="{{ $arr->transdetail }}" hidden>
                    <input type="text" name="quantity" value="{{ $arr->deposited }}" hidden>
                    <input type="text" name="subtotal" value="{{ array_sum($prices) }}" hidden>
                    <input type="text" name="shipping" value="1050" hidden>
                    <input type="text" name="total" value="{{ (array_sum($prices)) + (((array_sum($prices))/100)*1) + 1050 }}" hidden>
                    <input type="text" name="deliveryhandler" id="textbox2" value="client" hidden>
                    <button type="submit" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Accept
                    Purchase
                    </button>
                  </form>
                  <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-download"></i> Generate PDF 
                  </button>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <script>
    
        $( document ).ready(function() {
          $('#lnkPrint').click(function()
          {
            window.print();
          });
        });

        function myFunction() {
            var checkBox = document.getElementById("deliveryfee");
            var text = document.getElementById("text");
            if (checkBox.checked == true){
                text.style.display = "block";
                $('#textbox2').val('vendor');
            } else {
                text.style.display = "none";
                $('#textbox2').val('client');
            }
        }

    </script>

@endsection
