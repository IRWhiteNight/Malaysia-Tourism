<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple HTML Page with Navbar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <style>
        body {
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }

        .header1 {
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .navbar {
            background-color: #000000;
            padding: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-bottom: 2px solid rgb(0, 183, 255);
        }

        .navbar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .nav-item {
            margin: 0 1rem;
        }

        .nav-item a {
            color: rgb(165, 165, 165);
            text-decoration: none;
            font-size: 15px;
            margin-left: 20px;
            margin-right: 20px;
        }

        .nav-item a:hover {
            color: white;
        }

        .imgsize {
            width: 15%;
            margin-bottom: -10px;
        }

        i {
            font-size: 15px;
        }

        .card-container {
            display: flex;
            align-items: center;
            overflow-x: auto;
            gap: 20px;
            padding: 20px;
            max-width: 70%;
            width: 100%;
            height: 350px;
            margin: auto;
            margin-top:-20px;
        }

        .card {
            flex: 0 0 auto;
            width: 200px;
            height: 300px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 10px;
        }

        .card-title {
            font-size: 20px;
            text-align: center;
        }

        .size {
            width: 100%;
        }

        .middle {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            margin: auto;
        }

        .search-box {
            margin-top: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .search-box input[type="text"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 300px;
            margin-right: 10px;
        }

        .search-box button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-box button:hover {
            background-color: rgb(0, 150, 200);
        }

        .bodymain {
            background-color: white;
            position: relative;
            padding: 20px;
        }

        #map {
            border:2px solid rgb(0, 183, 255);
            border-radius:10px;
            height: 600px; /* Adjust the height as needed */
            width: 100%;
            margin-bottom: 20px; /* Add some bottom margin */
        }

        /* Styling for the input form */
        #floating-panel {
            position: absolute;
            top: 30px; /* Adjust the top position */
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
        .design{
            margin-top:10px;
            width: 90%;
            height:350px;
            border:4px solid rgb(0, 183, 255);
        }
    </style>
</head>
<body class="header1">
    <nav class="navbar">
        <ul class="navbar-nav">
            <li class="nav-item"><a href="#"><img class="imgsize" src="img/logosirkhairul-01.png" alt="Logo"></a></li>
            <li class="nav-item"><a href="#">About</a></li>
        </ul>
    </nav>

    <!-- Main content -->
    <div class="middle">
        <!-- Search Box -->
        <div class="search-box">
            <!-- Search form -->
            <form method="GET">
                <label for="stateSearch">Search by State:</label>
                <input type="text" id="stateSearch" name="stateSearch">
                <button type="submit">Search</button>
            </form>
        </div>

        <!-- Card Container -->
        <div class="design">
            <div class="card-container">
                <?php
                // PHP code to fetch and filter place data based on state search
                $url = "http://localhost/example/places"; // Adjust URL as per your setup
                $client = curl_init($url);
                curl_setopt($client, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($client);
                $result = json_decode($response);

                // Filter places based on state if search query is present
                $filteredPlaces = [];
                if ($result !== null) {
                    if(isset($_GET['stateSearch']) && !empty($_GET['stateSearch'])) {
                        $filteredPlaces = array_filter($result, function($place) {
                            return stripos($place->place_state, $_GET['stateSearch']) !== false;
                        });
                    } else {
                        $filteredPlaces = $result;
                    }

                    // Display filtered places in cards
                    foreach ($filteredPlaces as $place) {
                        echo "<div class='card'>";
                        echo "  <div class='card-body'>";
                        echo "      <img src='" . $place->place_img . "' class='size' alt='Card Image'>";
                        echo "      <p class='card-title'>" . $place->place_name . "</p>";
                        // Update this line to include place_id in the href attribute
                        echo "      <a href='review.php?place_id=" . $place->place_id . "' class='btn btn-primary'>Review</a>";
                        echo "  </div>";
                        echo "</div>";
                    }
                } else {
                    echo "Failed to fetch place data from the API.";
                }
                ?>
            </div>
        </div>
    </div>

    <div class="bodymain">
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
    </div>

    <script>
        // JavaScript code for filtering cards and handling review functionality
        function filterCards() {
            var input = document.getElementById('searchInput').value.toLowerCase();
            var cards = document.querySelectorAll('.card');

            cards.forEach(function(card) {
                var title = card.querySelector('.card-title').innerText.toLowerCase();
                if (title.includes(input)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Function to handle card click event
        function handleCardClick(placeId) {
            // Redirect to review.php with place_id as query parameter
            window.location.href = `review.php?place_id=${placeId}`;
        }

        // Add event listeners to each card to capture click events
        var cards = document.querySelectorAll('.card');
        cards.forEach(function(card) {
            card.addEventListener('click', function() {
                // Extract the place_id from the card data attribute
                var placeId = card.getAttribute('data-place-id');
                // Call the function to handle the click event and pass the place_id
                handleCardClick(placeId);
            });
        });

        // Google Maps JavaScript API functions (initMap, calculateAndDisplayRoute, etc.) should be placed here

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXPggs2ckwyrCZDxwA-tyktbihU1BgSUM&callback=initMap&v=weekly" defer></script>
</body>
</html>
