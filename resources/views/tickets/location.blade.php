<style>
  #map{
    width: 100% !important;
    height: 300px !important;
  }
</style>

<div id="map"></div>

@if (empty(env('MAPKEY')))
  <script src="https://maps.googleapis.com/maps/api/js"></script>
@else
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?callback=initMap{{env('MAPKEY')}}" async defer></script>
@endif


<script type="text/javascript">
// When the window has finished loading create our google map below
google.maps.event.addDomListener(window, 'load', init);

function init() {

  var draggable = Boolean({{ isset($drag) ? $drag : true }}); // Default to Draggable
  var lat = parseFloat({{ isset($lat) ? $lat : -6.175189725775392}}); // default to Monas
  var long = parseFloat({{ isset($long) ? $long : 106.82715279899882}}); // default to Monas

  var mapOptions = {
    center: new google.maps.LatLng(lat, long),
    zoom: 14,

    styles: [{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2e5d4"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#c5dac6"}]},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},{"featureType":"road","elementType":"all","stylers":[{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#c5c6c6"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#e4d7c6"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#fbfaf7"}]},{"featureType":"water","elementType":"all","stylers":[{"visibility":"on"},{"color":"#acbcc9"}]}]
  };

  // Get the HTML DOM element that will contain your map 
  // We are using a div with id="map" seen below in the <body>
  var mapElement = document.getElementById('map');

  // Create the Google Map using our element and options defined above
  var map = new google.maps.Map(mapElement, mapOptions);

  // Let's also add a marker while we're at it
  var marker = new google.maps.Marker({
    position: new google.maps.LatLng(lat, long),
    map: map,
    title: 'Drag untuk update koordinat',
    draggable: draggable
  });

  // console.log(marker)

  marker.addListener('drag', function(e){
    handleEvent(e,'lat','lng');
  });
      
      // var infowindow = new google.maps.InfoWindow({
      //     content: '<h4>Marker untuk Koordinat Latlng 1</h4>'
      // });
      // infowindow.open(map, marker);
  }

  function handleEvent(event,lat,lng) {
  document.getElementById(lat).value = event.latLng.lat();
  document.getElementById(lng).value = event.latLng.lng();
  }
</script>