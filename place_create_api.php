<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization");

$data = json_decode(file_get_contents("php://input"), true);

$place_name = $data["place_name"] ?? '';
$place_address = $data["place_address"] ?? '';
$place_state = $data["place_state"] ?? '';
$place_img = $data["place_img"] ?? '';

require_once "dbconnect.php";

$query = "INSERT INTO places (place_name, place_address, place_state, place_img) VALUES ('$place_name', '$place_address', '$place_state', '$place_img')";
$result = mysqli_query($conn, $query) or die("Insert Query Failed");

if ($result) {
    echo json_encode(array("message" => "Place Created Successfully", "status" => true));
} else {
    echo json_encode(array("message" => "Failed to Create Place", "status" => false));
}
?>
