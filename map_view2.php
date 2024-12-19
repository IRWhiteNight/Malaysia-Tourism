<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap&v=weekly"
      defer
    ></script>
    <script>
      let directionsService;
      let directionsRenderer;
      let map;
      let startMarker;
      let endMarker;

      function initMap() {
        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer();
        map = new google.maps.Map(document.getElementById("map"), {
          zoom: 7,
          center: { lat: 41.85, lng: -87.65 },
        });

        directionsRenderer.setMap(map);

        document.getElementById("submit").addEventListener("click", function() {
          calculateAndDisplayRoute();
        });

        document.getElementById("auto-detect").addEventListener("change", function() {
          if (this.checked) {
            detectUserLocation();
          } else {
            document.getElementById("start").readOnly = false;
            document.getElementById("start").value = "";
          }
        });

        // Get user's current location
        if (navigator.geolocation) {
          document.getElementById("auto-detect").disabled = false; // Enable auto-detect checkbox
        } else {
          // Browser doesn't support Geolocation
          document.getElementById("auto-detect-label").innerText = "Geolocation is not supported by your browser.";
        }
      }

      function calculateAndDisplayRoute() {
        const start = document.getElementById("start").value;
        const end = document.getElementById("end").value;

        directionsService
          .route({
            origin: start,
            destination: end,
            travelMode: google.maps.TravelMode.DRIVING,
          })
          .then((response) => {
            directionsRenderer.setDirections(response);
            displayDistance(response);

            // Add markers for start and end points
            addMarkers(response);
          })
          .catch((e) => window.alert("Directions request failed due to " + e));
      }

      function displayDistance(response) {
        const route = response.routes[0];
        let totalDistance = 0;

        for (let i = 0; i < route.legs.length; i++) {
          totalDistance += route.legs[i].distance.value;
        }

        const distanceInKm = totalDistance / 1000; // Convert distance to kilometers
        document.getElementById("distance").innerText = `Total Distance: ${distanceInKm.toFixed(2)} km`;
      }

      function addMarkers(response) {
        const startLocation = response.routes[0].legs[0].start_location;
        const endLocation = response.routes[0].legs[0].end_location;

        // Remove existing markers
        if (startMarker) {
          startMarker.setMap(null);
        }
        if (endMarker) {
          endMarker.setMap(null);
        }

        // Add new markers
        startMarker = new google.maps.Marker({
          position: startLocation,
          map: map,
          title: 'Start'
        });
        endMarker = new google.maps.Marker({
          position: endLocation,
          map: map,
          title: 'End'
        });
      }

      function detectUserLocation() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(
            (position) => {
              const userLocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
              };
              map.setCenter(userLocation);
              document.getElementById("start").readOnly = true;
              document.getElementById("start").value = `${userLocation.lat},${userLocation.lng}`;
            },
            () => {
              // Handle error if user denies geolocation permission
              alert("Geolocation permission denied. Please enter your location manually.");
              document.getElementById("auto-detect").checked = false;
            }
          );
        } else {
          // Browser doesn't support Geolocation
          alert("Geolocation is not supported by your browser. Please enter your location manually.");
          document.getElementById("auto-detect").checked = false;
        }
      }

      window.initMap = initMap;
    </script>
    <style>
       .bodymain{
        background-color:white;
       }
       #map {
            height: 600px; /* Adjust the height as needed */
            width: 100%;
            margin-bottom: 20px; /* Add some bottom margin */
        }

        /* Styling for the input form */
        #floating-panel {
            position: absolute;
            top: 20px; /* Adjust the top position */
            left: 50%;
            transform: translateX(-50%);
            z-index: 5;
            background-color: #fff;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            font-family: "Arial", sans-serif;
        }

        /* Styling for input fields and button */
        input[type="text"] {
            padding: 8px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            width: 200px;
            font-size: 14px;
        }

        #submit {
            padding: 8px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 14px;
        }

        #submit:hover {
            background-color: #0056b3;
        }

        /* Styling for the distance text */
        #distance {
            margin-top: 10px;
            font-size: 14px;
        }

        /* Styling for the auto-detect checkbox */
        #auto-detect-label {
          font-size: 14px;
          margin-bottom: 5px;
        }
    </style>
</head>
<body class="bodymain">
    <div id="floating-panel">
        <label id="auto-detect-label" for="auto-detect">Auto-detect user current location:</label>
        <input type="checkbox" id="auto-detect" disabled>
        <br>
        <input type="text" id="start" placeholder="Enter start point">
        <input type="text" id="end" placeholder="Enter end point">
        <button id="submit">Submit</button>
        <div id="distance"></div>
    </div>
    <div id="map"></div>
</body>
</html>
