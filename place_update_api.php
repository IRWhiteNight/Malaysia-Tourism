<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization");

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data["place_id"]) || !isset($data["place_name"]) || !isset($data["place_address"])) {
    echo json_encode(array("message" => "Invalid request data.", "status" => false));
    exit();
}

$place_id = $data["place_id"];
$place_name = $data["place_name"];
$place_address = $data["place_address"];

// Sanitize input data (consider using prepared statements for better security)

require_once "dbconnect.php";

$query = "UPDATE places SET place_name = '$place_name', place_address = '$place_address' WHERE id = $place_id";

$result = mysqli_query($conn, $query);

if ($result) {
    if (mysqli_affected_rows($conn) > 0) {
        echo json_encode(array("message" => mysqli_affected_rows($conn) . " Place Updated Successfully", "status" => true));
    } else {
        echo json_encode(array("message" => "Failed: Place Not Updated", "status" => false));
    }
} else {
    echo json_encode(array("message" => "Failed: Place Not Updated", "status" => false));
}

mysqli_close($conn);
?>
