@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
       Create Transaction Order
    </div>

    <div class="card-body">
        <form action="{{ route('storetransactions') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
      <div class="row">
        <label class="col-md-3">Vendor</label>
      <select class="form-control col-sm-4" name="vendor_id">
        <option>Select Vendor</option>
        @foreach ($items as $key => $value)
          <option value="{{ $key }}" > 
              {{ $value }} 
          </option>
      @endforeach    
    </select>
  </select>
</div>
<div class="row">
        <label class="col-md-3">Client</label>
    <select class="form-control col-sm-4" name="client_id">
      <option>Select Client</option>
      @foreach ($clients as $key => $value)
          <option value="{{ $key }}" > 
              {{ $value }} 
          </option>
      @endforeach    
  </select>
      </div>

         
            <div class="card">
                <div class="card-header">
                    Products
                </div>

                <div class="card-body">
                    <table class="table" id="products_table">
                        <thead>
                            <tr>
                            <th>Product</th>
                        <th>Item Description</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Amount</th>
                        <th>Image</th>
                            </tr>
                        </thead>
                        <tbody id="product_row">
                            @foreach (old('products', ['']) as $index => $oldProduct)
                                <tr id="product{{ $index }}">
                                    <td>
                                        <select name="products" class="form-control">
                                            <option value="">-- choose product --</option>
                                            @foreach ($prds as $product)
                                                <option value="{{ $product->id }}"{{ $oldProduct == $product->id ? ' selected' : '' }}>
                                                    {{ $product->name }} (Kshs.{{ number_format($product->price, 2) }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
 
                        <td>
                            <input type="string" name="itemdesc" class="form-control" value="" placeholder="item description" />
                        </td>
                        <td>
                            <input type="number" name="quantities" class="form-control" value="{{ old('quantities.' . $index) ?? '1' }}" />
                        </td>
                        <td>
                            <input type="number" name="prices" class="form-control" value="1" />
                        </td>
                        <td>
                            <input type="number" name="amount" class="form-control" value="1" />
                        </td>
                        <td>
                           
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input id="profile_image[]" type="file" class="form-control" name="profile_image[]">
                                        @if (auth()->user()->image)
                                            <code>{{ auth()->user()->image }}</code>
                                        @endif
                                    </div>
                                </div>
                        </td>
                                </tr>
                            @endforeach
                            <tr id="product{{ count(old('products', [''])) }}"></tr>
                        </tbody>
                    </table>

                    <!-- Need to eatablish how to save multiple product tarnsactions through the add row capability-->
                    
                    <!-- <div class="row">
                        <div class="col-md-12">
                            <button id="add_row" class="btn btn-default pull-left">+ Add Row</button>
                            <button id='delete_row' class="pull-right btn btn-danger">- Delete Row</button>
                        </div>
                    </div> -->
                </div>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}"> 
            </div>
        </form>


    </div>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function(){
    let row_number = {{ count(old('products', [''])) }};
    $("#add_row").click(function(e){
      e.preventDefault();
      let new_row_number = row_number - 1;
      $('#product' + row_number).html($('#product' + new_row_number).html()).find('td:first-child');
      $('#products_table').append('<tr id="product' + (row_number + 1) + '"></tr>');
      row_number++;
    });

    $("#delete_row").click(function(e){
      e.preventDefault();
      if(row_number > 1){
        $("#product" + (row_number - 1)).html('');
        row_number--;
      }
    });

	$('#products_table tbody').on('keyup change',function(){
		calc();
	});
	$('#tax').on('keyup change',function(){
		calc_total();
	});

  });
  function calc()
{
	$('#products_table tbody tr').each(function(i, element) {
		var html = $(this).html();
		if(html!='')
		{
			var qty = $(this).find('.quantities').val();
			var price = $(this).find('.price').val();
			$(this).find('.amount').val(qty*price);
			
		//	calc_total();
		}
    });
}

function calc_total()
{
	total=0;
	$('.total').each(function() {
        total += parseInt($(this).val());
    });
	$('#sub_total').val(total.toFixed(2));
	tax_sum=total/100*$('#tax').val();
	$('#tax_amount').val(tax_sum.toFixed(2));
	$('#total_amount').val((tax_sum+total).toFixed(2));
} 
 
 
</script>
@endsection
