
@extends('layouts.admin')
@section('content')

<style>
  #map {
    height: 400px;
    width: 100%;
    padding-top: 5px;
  }
</style>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Add Client</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href=" {{ route('clients') }}">Clients</a></li>
          <li class="breadcrumb-item active">Add Cient</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<section class="content">
<div class="container-fluid">
  <form id="clientForm" method="post" action="{{ route('storeclient') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
      <div class="row">
        <label class="col-md-3">First Name</label>
        <div class="col-md-4"><input type="text" name="firstname" class="form-control"></div>
        <div class="clearfix"></div>
      </div><div class="row">
        <label class="col-md-3">Middle Name</label>
        <div class="col-md-4"><input type="text" name="middlename" class="form-control"></div>
        <div class="clearfix"></div>
      </div>
      <div class="row">
        <label class="col-md-3">Last Name</label>
        <div class="col-md-4"><input type="text" name="lastname" class="form-control"></div>
        <div class="clearfix"></div>
      </div>
      <div class="row">
        <label class="col-md-3">ID No.</label>
        <div class="col-md-4"><input type="text" name="idno" class="form-control"></div>
        <div class="clearfix"></div>
      </div>
      <div class="row">
        <label class="col-md-3">Country</label>
        <div class="col-md-4"><input type="text" name="country" class="form-control"></div>
        <div class="clearfix"></div>
      </div>
      
      <div class="row">
        <label class="col-md-3">Email</label>
        <div class="col-md-4"><input type="text" name="email" class="form-control"></div>
        <div class="clearfix"></div>
      </div>
      <div class="row">
        <label class="col-md-3">Phone</label>
        <div class="col-md-4"><input type="text" name="phoneno" class="form-control"></div>
        <div class="clearfix"></div>
      </div>     
      <div class="row p-2">
        <label class="col-md-3 p-2">Terms & Conditions</label>
        <div class="col-md-4"><input type="checkbox" name="acceptedtnc" class="form-control"></div>
        <div class="clearfix"></div>
      </div>   

      <div class="row">
        <label class="col">Set Your PickUp Location Below: <small>(Please enter a valid location as possible, e.g "example,city,country")</small></label>
        <div class="col-md-4"><input type="text" name="location" class="form-control" id="my-input-searchbox"></div>
        <div class="clearfix"></div>
      </div>

      <div class="form-group">
        <!-- <label for="address_address">Physical Address</label>
        <input type="text" id="address-input" name="address_address" class="form-control map-input">
        <input type="hidden" name="address_latitude" id="address-latitude" value="0" />
        <input type="hidden" name="address_longitude" id="address-longitude" value="0" /> -->
        <div id="map"></div>
      </div>

    <div class="form-group">
      <input type="submit" class="btn btn-info" value="Save">
    </div>
  
  </form>
  

</div>
</section>

@section('scripts')
    @parent
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCnGwWFUlm1QJuI8WDZeBVxHzS6Bhzknmo&libraries=places"></script>

    <script>
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
                console.log(LatLng.lng)

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
    </script>
@stop
@endsection

