<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once "dbconnect.php";

$response = array(); // Initialize response array

if (isset($_GET['place_id']) && $_GET['place_id'] != '') {
    $id = $_GET['place_id'];
    $query = "SELECT * FROM places WHERE place_id=" . $id; // Change $place_id to $id

    $result = mysqli_query($conn, $query) or die("Select Query Failed.");

    $count = mysqli_num_rows($result);
    if ($count > 0) {
         $row = mysqli_fetch_assoc($result);
         $response['place_id'] = $row['place_id'];
         $response['place_name'] = $row['place_name'];
         $response['place_address'] = $row['place_address'];
         $response['place_state'] = $row['place_state']; // Add state data to the response
         $response['place_img'] = $row['place_img']; // Add image data to the response
         http_response_code(200);
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "No place found", "status" => false)); // Corrected 'massage' to 'message'
    }
}
$json_response = json_encode($response);
echo $json_response;
?>
