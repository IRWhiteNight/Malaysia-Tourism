<?php

$url = "http://localhost/example/places";

$client = curl_init($url);
curl_setopt($client, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($client);

$result = json_decode($response);

echo "<h1>Place List API Request</h1>";
echo "<a href='http://localhost/example/place_create_client.php'>Add Place</a>";

if ($result !== null) {
    echo '<table border="1">';
    echo "<TR><th>ID</th><th>Place Name</th><th>Place Address</th><th>Place State</th><th>Place Image</th><th>Action</th></TR>";
    foreach ($result as $place) {
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
