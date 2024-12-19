<?php

if (!isset($_GET["place_id"])) {
    echo "Place ID is missing in the URL.";
    exit();
}

$place_id = $_GET["place_id"];
$url = "http://localhost/example/place_delete_api.php?place_id=" . $place_id;

$client = curl_init($url);
curl_setopt($client, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($client, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($client);

if ($response === false) {
    echo "Error occurred while executing the DELETE request: " . curl_error($client);
    exit();
}

$result = json_decode($response);

if ($result === null || !isset($result->status) || !isset($result->message)) {
    echo "Unexpected response from server.";
    exit();
}

if ($result->status) {
    echo "Place with ID $place_id has been successfully deleted.";
} else {
    echo "Failed to delete place with ID $place_id. Error: " . $result->message;
}

curl_close($client);
?>

<a href='http://localhost/example/place_list_client.php'> Back to Main</a>
