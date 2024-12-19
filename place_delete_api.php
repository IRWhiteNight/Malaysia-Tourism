<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization");

if (!isset($_GET["place_id"])) {
    echo json_encode(array("message" => "Place ID is missing.", "status" => false));
    exit();
}

$place_id = $_GET["place_id"];

require_once "dbconnect.php";

$query = "DELETE FROM places WHERE place_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $place_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(array("message" => "Place deleted successfully.", "status" => true));
} else {
    echo json_encode(array("message" => "Failed to delete place.", "status" => false));
}

$stmt->close();
$conn->close();

?>
