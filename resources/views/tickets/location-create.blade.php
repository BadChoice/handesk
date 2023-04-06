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

<input
  id="pac-input"
  class="controls"
  type="text"
  placeholder="Search Box"
/>
<div id="map"></div>

 <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{env('MAPKEY')}}&callback=initAutocomplete&libraries=places&v=weekly" sync defer></script>

<script type="text/javascript">
  function initAutocomplete() {
    const map = new google.maps.Map(document.getElementById("map"), {
      center: { lat: -6.175189725775392, lng: 106.82715279899882 },
      zoom: 13,
      mapTypeId: "roadmap",
    });
    // Create the search box and link it to the UI element.
    const input = document.getElementById("pac-input");
    const searchBox = new google.maps.places.SearchBox(input);

    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    // Bias the SearchBox results towards current map's viewport.
    map.addListener("bounds_changed", () => {
      searchBox.setBounds(map.getBounds());
    });

    let marker;
    let markers = [];

    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener("places_changed", () => {
      const places = searchBox.getPlaces();

      if (places.length == 0) {
        return;
      }

      // Clear out the old markers.
      markers.forEach((marker) => {
        marker.setMap(null);
      });
      markers = [];

      // For each place, get the icon, name and location.
      const bounds = new google.maps.LatLngBounds();

      places.forEach((place) => {
        if (!place.geometry || !place.geometry.location) {
          console.log("Returned place contains no geometry");
          return;
        }

        // Create a marker for each place.
        markers.push(
          new google.maps.Marker({
            map,
            title: place.name,
            position: place.geometry.location,
            draggable:false
          })
        );

        if (place.geometry.viewport) {
          // Only geocodes have viewport.
          bounds.union(place.geometry.viewport);
        } else {
          bounds.extend(place.geometry.location);
        }

        handleEvent(place.geometry.location.lat(), place.geometry.location.lng());
      });
      
      map.fitBounds(bounds);
    });

    google.maps.event.addListener(map, 'click', function(e) {
      // Clear out the old markers.
      markers.forEach((marker) => {
        marker.setMap(null);
      });
      

      marker = new google.maps.Marker({ map: map, position: e.latLng });
      markers.push(marker);

      handleEvent(e.latLng.lat(), e.latLng.lng());
      
    });

  }

  window.initAutocomplete = initAutocomplete;

  function handleEvent(lat, lng) {
    document.getElementById('lat').value = lat;
    document.getElementById('lng').value = lng;
  }
</script>