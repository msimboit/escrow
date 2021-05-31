@extends('layouts.admin')
@section('content')

<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Receipts</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href=" {{ route('transactions') }}">Transactions</a></li>
            <li class="breadcrumb-item active">Receipts</li>
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
                <div class="col-12 my-5">
                  <h4>
                    <i class="fas fa-globe"></i> Receipt
                    <small class="float-right">Date: {{ $arr['orderdate'] }}</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <div class="row">
                <div class="col-sm-6 mx-auto my-5">
                  <h4>
                    Thank You for using Escrow!
                  </h4>
                  <p>Below are your receipt details</p>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info d-flex justify-content-center align-items-center">
                <div class="col-sm-4 invoice-col">
                  From
                  <address>
                    <strong>{{ $arr['vendorName'] }}</strong><br>
                    Phone: {{ $arr['vendorNumber'] }}<br>
                    Email: {{ $arr['vendorEmail'] }}<br>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  To
                  <address>
                    <strong>{{ $arr['clientName'] }}</strong><br>
                    Phone: {{ $arr['clientNumber'] }}<br>
                    Email: {{ $arr['clientEmail'] }}<br>
                  </address>
                </div>
                
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive my-5">
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
                      <td>{{ $arr['transdetail'] }}</td>
                      <td>{{ $arr['quantity']}}</td>
                      <td>{{ $arr['subtotal']}}</td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <!-- <div class="col-6 p-2">
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
                </div> -->
                <!-- /.col -->
                <div class="col-sm-6 mx-auto">
                  <p class="lead">Amount Paid</p>

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>Kshs.{{ $arr['subtotal'] }}</td>
                      </tr>
                      <tr>
                        <th>Tax (16%)</th>
                        <td>Kshs.{{ (($arr['subtotal'])/100)*16 }}.00</td>
                      </tr>
                      <tr>
                        <th>Shipping:</th>
                        <td>Kshs.1050</td>
                      </tr>
                      <tr>
                        <th>Delivery Fee of Kshs.500 <br /> Handled By:</th>
                        <td>
                            <strong>{{ $arr['deliveryfee'] }}</strong>
                        </td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>Kshs.{{ ($arr['subtotal']) + ((($arr['subtotal'])/100)*16) + 1050 }}</td>
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
</script>
@endsection
