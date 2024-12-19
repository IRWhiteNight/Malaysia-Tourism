<!DOCTYPE html>
<html>
<head>
    <title>Place Update API Request</title>
</head>
<body>
<h1>Place Update API Request</h1>

<?php 
require_once "dbconnect.php";

if (isset($_GET['place_id'])) {
    $place_id = $_GET['place_id'];
    
    // Fetch place details from the database
    $query = "SELECT * FROM places WHERE place_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $place_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $place = $result->fetch_assoc();
    $stmt->close();

    if ($place) {
        echo "ID : " . $place['place_id']; 
        echo "<br>Place Name : " . $place['place_name']; 
        echo "<br>Place Address : " . $place['place_address']; 
        echo "<br>Place state : " . $place['place_state']; 
        echo "<br>Place Image : " . $place['place_img']; 
?>

<form method="POST">
    <br>
    Place Name: <br>
    <input type="text" name="place_name" value="<?php echo htmlspecialchars($place['place_name']); ?>">
    <br>
    Place Address : <br>
    <input type="text" name="place_address" value="<?php echo htmlspecialchars($place['place_address']); ?>">
    <br>
    Place State : <br>
    <input type="text" name="place_state" value="<?php echo htmlspecialchars($place['place_state']); ?>">
    <br>
    Place Image : <br>
    <input type="text" name="place_img" value="<?php echo htmlspecialchars($place['place_img']); ?>">
    <br>
    <input type="hidden" name="place_id" value="<?php echo $place['place_id']; ?>">
    <input type="submit" name="submit" value="submit">
</form>

<?php
    } else {
        echo "Failed to fetch place details. Place not found.";
        exit();
    }

    if (isset($_POST['submit'])) {
        $place_id = $_POST['place_id'];
        $place_name = $_POST['place_name'];
        $place_address = $_POST['place_address'];
        $place_state = $_POST['place_state'];
        $place_img = $_POST['place_img'];

        // Update place details in the database
        $update_query = "UPDATE places SET place_name = ?, place_address = ?, place_state = ?, place_img = ? WHERE place_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("ssi", $place_name, $place_address,$place_state,$place_img, $place_id);
        $update_stmt->execute();

        if ($update_stmt->affected_rows > 0) {
            echo '<p>Place updated successfully.</p>';
        } else {
            echo '<p>Error updating place or no changes made.</p>';
        }

        $update_stmt->close();
        echo '<a href="http://localhost/example/place_list_client.php">Back</a>';
    }
} else {
    echo 'Invalid request';
}

$conn->close();
?>
</body>
</html>
