<?php

$url = "http://localhost/example/reviews";

$client = curl_init($url);
curl_setopt($client, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($client);

$result = json_decode($response);

echo "<h1>Review List API Request</h1>";
echo "<a href='http://localhost/example/review_create_client.php'>Add Review</a>";
echo '<table border="1">';
echo "<TR><th>ID</th><th>Place ID</th><th>User Name</th><th>Review Title</th><th>Review Text</th><th>Rating</th><th>Date</th><th>Action</th></TR>";
foreach ($result as $review) {
    echo "<tr>";
    echo "<td>" . $review->review_id . "</td>";
    echo "<td>" . $review->place_id . "</td>";
    echo "<td>" . $review->user_name . "</td>";
    echo "<td>" . $review->review_title . "</td>";
    echo "<td>" . $review->review_text . "</td>";
    echo "<td>" . $review->review_rating . "</td>";
    echo "<td>" . $review->reviewDate . "</td>";
    echo "<td><a href='http://localhost/example/review_update_client.php?review_id=" . $review->review_id . "'>Update</a> | ";
    echo "<a href='http://localhost/example/review_delete_client.php?review_id=" . $review->review_id . "'>Delete</a></td>";
    echo "</tr>";
}
echo "</table>";

?>
