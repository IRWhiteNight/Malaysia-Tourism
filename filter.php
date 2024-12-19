<?php

$url = "http://localhost/example/places";

$client = curl_init($url);
curl_setopt($client, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($client);

$result = json_decode($response);

echo "<h1>Place List API Request</h1>";
echo "<a href='http://localhost/example/place_create_client.php'>Add Place</a>";

// Search form
echo '<form method="get">';
echo '  <label for="stateSearch">Search by State:</label>';
echo '  <input type="text" id="stateSearch" name="stateSearch">';
echo '  <button type="submit">Search</button>';
echo '</form>';

if ($result !== null) {
    // Filter places based on state if search query is present
    $filteredPlaces = array_filter($result, function($place) {
        if(isset($_GET['stateSearch']) && !empty($_GET['stateSearch'])) {
            return stripos($place->place_state, $_GET['stateSearch']) !== false;
        }
        return true;
    });

    echo '<table border="1">';
    echo "<tr><th>ID</th><th>Place Name</th><th>Place Address</th><th>Place State</th><th>Place Image</th><th>Action</th></tr>";
    foreach ($filteredPlaces as $place) {
        echo "<tr>";
        echo "<td>" . $place->place_id . "</td>";
        echo "<td>" . $place->place_name . "</td>";
        echo "<td>" . $place->place_address . "</td>";
        echo "<td>" . $place->place_state . "</td>";
        echo "<td>" . "<img src='" . $place->place_img . "' style='width: 100px;'/>" . "</td>"; // Fix image display
        echo "<td><a href='http://localhost/example/place_update_client.php?place_id=" . $place->place_id . "'>Update</a> | ";
        echo "<a href='http://localhost/example/place_delete_client.php?place_id=" . $place->place_id . "'>Delete</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Failed to fetch place data from the API.";
}

?>
