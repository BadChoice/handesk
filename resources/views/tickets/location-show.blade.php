<style>
  /* 
  * Always set the map height explicitly to define the size of the div element
  * that contains the map. 
  */
  #map{
    width: 100% !important;
    height: 300px !important;
  }

  /* 
  * Optional: Makes the sample page fill the window. 
  */
  html,
  body {
    height: 100%;
    margin: 0;
    padding: 0;
  }

  #description {
    font-family: Roboto;
    font-size: 15px;
    font-weight: 300;
  }

  #infowindow-content .title {
    font-weight: bold;
  }

  #infowindow-content {
    display: none;
  }

  #map #infowindow-content {
    display: inline;
  }

  .pac-card {
    background-color: #fff;
    border: 0;
    border-radius: 2px;
    box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
    margin: 10px;
    padding: 0 0.5em;
    font: 400 18px Roboto, Arial, sans-serif;
    overflow: hidden;
    font-family: Roboto;
    padding: 0;
  }

  #pac-container {
    padding-bottom: 12px;
    margin-right: 12px;
  }

  .pac-controls {
    display: inline-block;
    padding: 5px 11px;
  }

  .pac-controls label {
    font-family: Roboto;
    font-size: 13px;
    font-weight: 300;
  }

  #pac-input {
    background-color: #fff;
    font-family: Roboto;
    font-size: 15px;
    font-weight: 300;
    margin-left: 12px;
    padding: 0 11px 0 13px;
    text-overflow: ellipsis;
    width: 400px;
  }

  #pac-input:focus {
    border-color: #4d90fe;
  }

  #title {
    color: #fff;
    background-color: #4d90fe;
    font-size: 25px;
    font-weight: 500;
    padding: 6px 12px;
  }

  #target {
    width: 345px;
  }
</style>

<div id="map"></div>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{env('MAPKEY')}}&callback=initMap" async defer></script>

<script type="text/javascript">
  // When the window has finished loading create our google map below
  function initMap() {

    var lat = parseFloat({{ isset($lat) ? $lat : -6.175189725775392}}); // default to Monas
    var long = parseFloat({{ isset($long) ? $long : 106.82715279899882}}); // default to Monas

    const coordinate = { lat: lat, lng: long }

    var mapOptions = {
      center: coordinate,
      zoom: 14,
      mapTypeId: "roadmap",
    };

    // Get the HTML DOM element that will contain your map 
    // We are using a div with id="map" seen below in the <body>
    var mapElement = document.getElementById('map');

    // Create the Google Map using our element and options defined above
    var map = new google.maps.Map(mapElement, mapOptions);

    var icon = {
      url: '{{url("images/logo.png")}}',
      size: new google.maps.Size(71, 71),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(17, 34),
      scaledSize: new google.maps.Size(25, 25),
    };

    new google.maps.Marker({
      map,
      icon,
      position: coordinate,
      draggable:false
    })
  }
</script>