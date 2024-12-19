<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization");

// Get the JSON data from the request body
$data = json_decode(file_get_contents("php://input"), true);

echo '<p>Receiving data from review client to review create API: ';
echo '</p>';

if (isset($data)) {
    // Extract data from the JSON
    $place_id = $data["place_id"] ?? '';
    $user_name = $data["user_name"] ?? '';
    $review_title = $data["review_title"] ?? '';
    $review_text = $data["review_text"] ?? '';
    $review_rating = $data["review_rating"] ?? '';
    $reviewDate = $data["reviewDate"] ?? '';

    // Validate required fields
    if (empty($place_id) || empty($user_name) || empty($review_title) || empty($review_text) || empty($review_rating)) {
        http_response_code(400);
        echo json_encode(array("message" => "All fields are required", "status" => false));
        exit();
    }

    require_once "dbconnect.php";

    // Use prepared statements to prevent SQL injection
    $query = $conn->prepare("INSERT INTO reviews (place_id, user_name, review_title, review_text, review_rating, reviewDate) VALUES (?, ?, ?, ?, ?, NOW())");
    $query->bind_param("sssss", $place_id, $user_name, $review_title, $review_text, $review_rating);

    // Execute the query
    if ($query->execute()) {
        if ($query->affected_rows > 0) {
            http_response_code(200);
            echo json_encode(array("message" => "Review Created Successfully", "status" => true));
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Failed to Create Review", "status" => false));
        }
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Database Error", "status" => false));
    }

    // Close the statement and connection
    $query->close();
    $conn->close();
} else {
    http_response_code(400);
    echo json_encode(array("message" => "No Data Received", "status" => false));
}
?>
