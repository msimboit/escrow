<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <title>My Geocode App</title>
</head>
<body>
  <div class="container">
    <h2 id="text-center">Enter Location: </h2>
    <form id="location-form">
      <input type="text" id="location-input" class="form-control form-control-lg">
      <br>
      <button type="button" class="btn btn-primary">Set Location</button>
    </form>
    <div class="card-block" id="formatted-address"></div>
    <div class="card-block" id="address-components"></div>
    <div class="card-block" id="geometry"></div>

    <form method="post" action="{{ route('updatelocation',$client->id) }}">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <button type="submit" value="submit" class="btn btn-primary">Complete</button>
    </form>
  </div>

  

  <script>
    // Call Geocode
    //geocode();

    // Get location form
    var locationForm = document.getElementById('location-form');

    // Listen for submiot
    // locationForm.addEventListener('submit', geocode);
    document.querySelector("button").addEventListener("click", geocode);

    function geocode(e){
      // Prevent actual submit
      e.preventDefault();

      var location = document.getElementById('location-input').value;

      axios.get('https://maps.googleapis.com/maps/api/geocode/json',{
        params:{
          address:location,
          key:'AIzaSyCnGwWFUlm1QJuI8WDZeBVxHzS6Bhzknmo'
        }
      })
      .then(function(response){
        // Log full response
        console.log(response);

        // Formatted Address
        var formattedAddress = response.data.results[0].formatted_address;
        var formattedAddressOutput = `
          <ul class="list-group">
            <li class="list-group-item">${formattedAddress}</li>
          </ul>
        `;

        // Address Components
        var addressComponents = response.data.results[0].address_components;
        var addressComponentsOutput = '<ul class="list-group">';
        for(var i = 0;i < addressComponents.length;i++){
          addressComponentsOutput += `
            <li class="list-group-item"><strong>${addressComponents[i].types[0]}</strong>: ${addressComponents[i].long_name}</li>
          `;
        }
        addressComponentsOutput += '</ul>';

        // Geometry
        var lat = response.data.results[0].geometry.location.lat;
        var lng = response.data.results[0].geometry.location.lng;
        var geometryOutput = `
          <ul class="list-group">
            <li class="list-group-item"><strong>Latitude</strong>: ${lat}</li>
            <li class="list-group-item"><strong>Longitude</strong>: ${lng}</li>
          </ul>
        `;

        // Output to app
        document.getElementById('formatted-address').innerHTML = formattedAddressOutput;
        document.getElementById('address-components').innerHTML = addressComponentsOutput;
        document.getElementById('geometry').innerHTML = geometryOutput;
      })
      .catch(function(error){
        console.log(error);
      });
    }
  </script>
</body>
</html>
