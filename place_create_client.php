<!DOCTYPE html>
<html>
<head>
    <title>Place API Request</title>
</head>
<body>
<h1>Place API Request</h1>
<form method="POST" enctype="multipart/form-data">
    <br>
    Place Name: <input type="text" name="place_name" required>
    <br>
    Place Address : <input type="text" name="place_address" required>
    <br>
    Place State : <input type="text" name="place_state" required>
    <br>
    Place Image : <input type="text" name="place_img" required>
    <br>
    <input type="submit" name="submit" value="submit">
</form>

<?php
if (isset($_POST['submit'])) {
    // Specify the URL ($url) where the JSON data to be sent
    $url = "http://localhost/example/place_create_api.php";

    // Initialize new cURL resource using curl_init().
    $ch = curl_init($url);

    // Setup request to send JSON via POST
    $data = array(
        'place_name' => $_POST['place_name'],
        'place_address' => $_POST['place_address'],
        'place_state' => $_POST['place_state'],
        'place_img' => $_POST['place_img'],
    );

    // Setup data in PHP array and encode into a JSON string using json_encode()
    $payload = json_encode($data);

    // Attach encoded JSON string to the POST fields
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    // Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

    // Return response instead of outputting
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Execute the POST request
    $result = curl_exec($ch);

    // Close cURL resource
    curl_close($ch);
    echo '<p>Receiving data from place client to place create API: ';
    var_dump($result);
    echo '</p>';
    echo '<a href="http://localhost/example/place_list_client.php">Back</a>';
}
?>
</body>
</html>
