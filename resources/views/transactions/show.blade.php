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
            <form action="{{ route('storetransactions') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> Invoice
                    <small class="float-right">Date: {{ $arr->created_at->format('d/m/Y H:i:s') }}</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  From
                  <address>
                    <strong>{{ $vdetails->firstname }}</strong><br>
                    Phone: {{ $vdetails->phoneno }}<br>
                    Email: {{ $vdetails->email }}<br>
                    Location: {{$vdetails->country }}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  To
                  <address>
                    <strong>{{ $cdetails->firstname }}</strong><br>
                    Phone: {{ $cdetails->phoneno }}<br>
                    Email: {{ $cdetails->email }}<br>
                    Location: {{$cdetails->country }}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Invoice</b><br>
                  <br>
                  <b>Order ID:</b> {{ $arr->id}}<br>
                  <b>Payment Due:</b> {{ $arr->created_at->format('d-m-Y')}}<br>
                  <b>Account:</b> 968-34567
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th></th>
                      <th>Description</th>
                      <th>Quantity</th>
                      <th>Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td></td>
                      <td>{{ $arr->transdetail}}</td>
                      <td>{{ $arr->deposited}}</td>
                      <td>{{ $arr->transamount}}</td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6 p-2">
                  <p class="lead">Payment Methods:</p>
                  <h5 style="margin: 5px; font-weight: bold;">MPESA:</h5>
                  <p class="text-muted well well-sm shadow-none" style="margin: 5px;">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                    plugg
                  </p>

                  <h5 style="margin: 5px; font-weight: bold;">Bank Transfer:</h5>
                  <p class="text-muted well well-sm shadow-none" style="margin: 5px;">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                    plugg
                  </p>
                </div>
                <!-- /.col -->
                <div class="col-6 p-2">
                  <p class="lead">Amount Due on {{ $arr->created_at->format('d-m-Y')}}</p>

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>Kshs.{{ $arr->transamount}}</td>
                      </tr>
                      <tr>
                        <th>Tax (16%)</th>
                        <td>Kshs.{{ (($arr->transamount)/100)*16 }}.00</td>
                      </tr>
                      <tr>
                        <th>Shipping:</th>
                        <td>Kshs.1050</td>
                      </tr>
                      <tr>
                        <th>Delivery Fee of Kshs.500 <br /> Handled By:</th>
                        <td>
                          <input type="checkbox" name="vendor" value="ven"><span style="margin:5px;">Vendor</span>  
                          <input type="checkbox" name="client" value="cli"> <span>Client</span>
                        </td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>Kshs.{{ ($arr->transamount) + ((($arr->transamount)/100)*16) + 1050 }}</td>
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
                  <button type="submit" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                    Payment
                  </button>
                  <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-download"></i> Generate PDF 
                  </button>
                </div>
              </div>
            </div>
          </form>
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

        $(document).ready(function(){
                $('input:checkbox').click(function() {
                    $('input:checkbox').not(this).prop('checked', false);
                          });
            });

    </script>

@endsection
