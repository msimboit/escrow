@extends('layouts.admin')
@section('content')

<style>
  #map {
    height: 350px;   
    width: 900px; 
    padding-top: 5px;
  }
</style>

<div class="card">
    <div class="card-header">
       Edit Transaction Order
    </div>
    <div class="card-body">
        <form action="{{ route('updatetransactions', $trans->id) }}" method="POST" enctype="multipart/form-data">
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
            <div class="row m-3">
            <label class="col-md-3">Vendor</label>
              <!-- <select class="form-control col-sm-4" name="vendor_id" required>
                <option>Select Vendor</option>
                @foreach ($vendors as $vendor)
                  <option value="{{ $vendor->phone_number }}" > 
                      {{ $vendor->first_name }} {{ $vendor->last_name }} - {{ $vendor->phone_number }}
                  </option>
              @endforeach    
            </select> -->
             @if(Auth::user()->role == 'vendor')
            <input type="text" name="{{ Auth::user()->phone_number}}" placeholder="{{ Auth::user()->business_name}} - {{ Auth::user()->phone_number}}" class="form-control col-sm-4 font-weight-bold" readonly>
            @endif
  </select>
</div>
<div class="row m-3">
        <label class="col-md-3">Buyer</label>
        <!-- For defining autocomplete -->
        <!-- <input type="text" id='client_search' class="p-1 mr-2" placeholder="Type the Client name"> -->
        <!-- For displaying selected option value from autocomplete suggestion -->
        <!-- <span class="p-1">Selected Client:</span> -->
        <!-- <input type="text" id='clientfirstname' readonly class="p-1 mr-2"> -->

        <!-- <select class="livesearch form-control col-sm-4" name="client_id" id="livesearch2"></select> -->
    <select class="form-control col-sm-4" name="client_id" required>
      <option>Select Buyer</option>
      @foreach ($clients as $client )
          <option value="{{ $client->phone_number }}" >
              {{ $client->first_name }} {{ $client->last_name }} - {{ $client->phone_number }}
          </option>
      @endforeach    
  </select>
  <!-- Works -->
  <!-- <input type="text" name="client_id" id="buyers" class="bsearch form-control col-sm-4 font-weight-bold" placeholder="Key in the Buyer number"> -->

  <div class="row mt-4 ml-3">
    <label >Set Your Delivery Location Below: <small>(Please enter a valid location as possible, e.g "example,city,country")</small></label>
    <div class="col-md-6"><input type="text" name="location" class="form-control" id="my-input-searchbox" required></div>
    <div class="clearfix"></div>
  </div>
  <div class="form-group">
        <div id="map"></div>
  </div>

  <div class="form-group">
    <label >Additional Location details: <small>(Describe if necessary the exact delivery location)</small></label>
    <input name="locationdetails" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
  </div>


      </div>

         
            <div class="card m-2">
                <div class="card-header">
                    <strong>Transaction Details:</strong> 
                </div>

                <div class="card-body">
                    <table class="table" id="products_table">
                        <thead>
                            <tr>
                                <!-- <th>Product</th> -->
                                <th>Item Description</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Image</th>
                            </tr>
                        </thead>

                        <tbody id="product_row" class="display-flex">
                            @foreach (old('products', ['']) as $index => $oldProduct)
                                <tr id="product{{ $index }}">
 
                        <td>
                            <!-- <input type="string" name="itemdesc[]" class="form-control" value="" placeholder="item description" /> -->
                            <textarea name="itemdesc[]" id="" value="{{ old('itemdesc.' . $index) ?? '1' }}" placeholder="item description" class="form-control" required></textarea>
                        </td>
                        <td>
                            <input type="number" name="quantities[]" class="form-control" value="{{ old('quantities.' . $index) ?? '1' }}" required>
                        </td>
                        <td>
                            <input type="number" name="prices[]" class="form-control" value="{{ old('prices' . $index) ?? '1' }}" required>
                        </td>
                        <td>
                        
                        <!-- Implemented image save??? -->
                        <div class="form-group row">
                            <!-- <div class="col-md-8"> -->
                                <input id="product_image[]" type="file" class="form-control" name="product_image[]">
                                        @if (auth()->user()->image)
                                            <code>{{ auth()->user()->image }}</code>
                                        @endif
                                    <!-- </div> -->

                                <!-- <input type="file" id="mypic" accept="image/*" capture="camera" class="m-3">
                                <canvas class="m-3" width="50" height="50"></canvas> -->
                                
                                </div>

                        
                        </td>

                                </tr>
                            @endforeach
                            <tr id="product{{ count(old('products', [''])) }}"></tr>
                        </tbody>
                    </table>

                    <!-- Need to eatablish how to save multiple product tarnsactions through the add row capability-->
                    
                    <div class="row">
                        <div class="col-md-10">
                            <button id="add_row" class="btn btn-primary pull-left ml-4"> Add Row</button>
                            <button id='delete_row' class="pull-right btn btn-danger mr-4"> Delete Row</button>
                        </div>
                    </div>
                   
                </div>
            </div>

            <div class="row mx-3 my-5 ">
            <label class="col-md-2">Pick-up Time:</label>
              <select class="form-control col-sm-4" name="deliverytime">
                <option>Select Delivery Time</option>
                <option value="2">Upto 2 hours</option>
                <option value="4">Upto 4 hours</option>
                <option value="8">Upto 8 hours</option>
                <option value="12">Upto 12 hours</option> 
                <option value="24">Upto 24 hours</option>
                <option value="36">Upto 36 hours</option>  
                <option value="72">Past 72 hours</option>          
              </select>
            </div>

            <div class="row m-3" hidden>
              <label class="col-md-2">Delivery Fee:</label>
            <input type="number" name="deliveryfee" class="form-control col-sm-2" value="0" />
            </div>

            <!-- <div class="row m-3 pt-2">
              <label class="col-md-2">Charging Fee Handled By:</label>
              <select class="form-control col-sm-4" name="delivery_fee_handler" required>
                <option>Select Delivery Fee Handler</option>
                <option value="client">Buyer</option>
                <option value="vendor">Vendor</option>      
              </select>
            </div> -->

            <div>
                <input type="text" name="lat" id="latitude" value="latitude" hidden>
                <input type="text" name="long" id="longitude" value="longitude" hidden>
                <input class="btn btn-success col-md-1.5 my-5 ml-5" type="submit" value="{{ trans('Save Transaction') }}"> 
            </div>
        </form>


    </div>
</div>
@endsection

@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCnGwWFUlm1QJuI8WDZeBVxHzS6Bhzknmo&libraries=places"></script>

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

var buyers = [];
$.ajax({
  url:"/buyer/search",
  type:"GET",
  success: function(result){
    console.log("success");
    console.log(result);
    result.forEach((item) => {
      buyers.push(item.phone_number);
      console.log(item.phone_number);
    });
    $('#buyers option:selected').val();
  },
  error:function(){
    console.log("error");
  }
});

// $(".bsearch").autocomplete("widget");
$( "#buyers" ).autocomplete({
      source: buyers
    });

// $('#livesearch').select2({
//         placeholder: 'Type Vendor Name',
//         ajax: {
//             url: '/ajax-autocomplete-search',
//             dataType: 'json',
//             delay: 250,
//             processResults: function (data) {
//                 return {
//                     results: $.map(data, function (item) {
//                         return {
//                             text: item.name
//                         }
//                     })
//                 };
//             },
//             cache: true
//         }
//     });

//     $('#livesearch2').select2({
//         placeholder: 'Type Client Name',
//         ajax: {
//             url: '/ajax-autocomplete-search2',
//             dataType: 'json',
//             delay: 250,
//             processResults: function (data) {
//                 return {
//                     results: $.map(data, function (item) {
//                         return {
//                             text: item.name
//                         }
//                     })
//                 };
//             },
//             cache: true
//         }
//     });


    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){

      $( "#vendor_search" ).autocomplete({
        source: function( request, response ) {
          // Fetch data
          $.ajax({
            url:"{{route('transaction.getVendors')}}",
            type: 'post',
            dataType: "json",
            data: {
               _token: CSRF_TOKEN,
               search: request.term
            },
            success: function( data ) {
               response( data );
            }
          });
        },
        select: function (event, ui) {
           // Set selection
           $('#vendor_search').val(ui.item.label); // display the selected text
           $('#vendorname').val(ui.item.value); // save selected id to input
           return false;
        }
      });

    });

    // CSRF Token
    // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    // $(document).ready(function(){

    //   $( "#client_search" ).autocomplete({
    //     source: function( request, response ) {
    //       // Fetch data
    //       $.ajax({
    //         url:"{{route('transaction.getClients')}}",
    //         type: 'post',
    //         dataType: "json",
    //         data: {
    //            _token: CSRF_TOKEN,
    //            search: request.term
    //         },
    //         success: function( data ) {
    //            response( data );
    //         }
    //       });
    //     },
    //     select: function (event, ui) {
    //        // Set selection
    //        $('#client_search').val(ui.item.label); // display the selected text
    //        $('#clientname').val(ui.item.value); // save selected id to input
    //        return false;
    //     }
    //   });

    // });


    // Map scripts start here
    function initAutocomplete() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {
                lat: -1.2860331873757733,
                lng: 36.82665965431366
                },
                zoom: 15,
                disableDefaultUI: true
            });

            // Create the search box and link it to the UI element.
            var input = document.getElementById('my-input-searchbox');
            var autocomplete = new google.maps.places.Autocomplete(input);
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
            var marker = new google.maps.Marker({
                map: map
            });

            // Bias the SearchBox results towards current map's viewport.
            autocomplete.bindTo('bounds', map);
            // Set the data fields to return when the user selects a place.
            autocomplete.setFields(
                ['address_components', 'geometry', 'name']);

            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                console.log("Returned place contains no geometry");
                return;
                }
                var bounds = new google.maps.LatLngBounds();
                marker.setPosition(place.geometry.location);
                var LatLng = place.geometry.location.toJSON();
                console.log(LatLng)
                console.log(LatLng.lat)
                $('#latitude').val(LatLng.lat);
                console.log(LatLng.lng)
                $('#longitude').val(LatLng.lng);

                if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
                } else {
                bounds.extend(place.geometry.location);
                }
                map.fitBounds(bounds);
            });
            }
            document.addEventListener("DOMContentLoaded", function(event) {
            initAutocomplete();
            });

            // Resize stuff...
  google.maps.event.addDomListener(window, "resize", function() {
    var center = map.getCenter();
    google.maps.event.trigger(map, "resize");
    map.setCenter(center); 
  });


            function getLocation() {
            var checkBox = document.getElementById("deliveryfee");
            var text = document.getElementById("text");
            if (checkBox.checked == true){
                text.style.display = "block";
                $('#textbox2').val('client');
            } else {
                text.style.display = "none";
                $('#textbox2').val('vendor');
            }
        }
 

        var input = document.querySelector('input[type=file]');
  input.onchange = function () {
    var file = input.files[0];
    //upload(file);
    drawOnCanvas(file);   
    //displayAsImage(file); 
  };
 
  function upload(file) {
    var form = new FormData(),
        xhr = new XMLHttpRequest();
 
    form.append('image', file);
    xhr.open('post', 'server.php', true);
    xhr.send(form);
  }
 
  function drawOnCanvas(file) {
    var reader = new FileReader();
    reader.onload = function (e) {
      var dataURL = e.target.result,
          c = document.querySelector('canvas'),
          ctx = c.getContext('2d'),
          img = new Image();
 
      img.onload = function() {
        c.width = img.width;
        c.height = img.height;
        ctx.drawImage(img, 0, 0);
      };
 
      img.src = dataURL;
    };
 
    reader.readAsDataURL(file);
  }
 
  function displayAsImage(file) {
    var imgURL = URL.createObjectURL(file),
        img = document.createElement('img');
 
    img.onload = function() {
      URL.revokeObjectURL(imgURL);
    };
 
    img.src = imgURL;
    document.body.appendChild(img);
  }

</script>

@endsection
