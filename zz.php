<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit a Review</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        /* Your custom CSS styles */
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <?php
                // Initialize $place_name and $place_img with default values
                $place_name = "Submit a Review";
                $place_img = ""; // Initialize with an empty string

                // Fetch place_name and place_img based on place_id if provided in URL
                if (isset($_GET['place_id'])) {
                    require_once "dbconnect.php";

                    $place_id = $_GET['place_id'];
                    $query = "SELECT place_name, place_img FROM places WHERE place_id = $place_id";
                    $result = mysqli_query($conn, $query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $place_name = htmlspecialchars($row['place_name']);
                        $place_img = htmlspecialchars($row['place_img']);
                    } else {
                        // Handle case where place_id does not match any place
                        $place_name = "Place Not Found";
                    }

                    // Close result set
                    mysqli_free_result($result);
                }
                ?>
                <!-- Display place image -->
                <img src="<?php echo $place_img; ?>" class="img-fluid mb-3" alt="Place Image">
                <!-- Display place name -->
                <h1><?php echo htmlspecialchars($place_name); ?></h1>
                <!-- Review submission form -->
                <form method="POST" action="review_create_api.php">
                    <div class="form-group">
                        <label for="place_id">Place ID:</label>
                        <input type="text" id="place_id" name="place_id" class="form-control" value="<?php echo isset($_GET['place_id']) ? htmlspecialchars($_GET['place_id']) : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="user_name">Your Name:</label>
                        <input type="text" id="user_name" name="user_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="review_title">Review Title:</label>
                        <input type="text" id="review_title" name="review_title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="review_text">Review Text:</label>
                        <textarea id="review_text" name="review_text" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="review_rating">Review Rating:</label>
                        <select id="review_rating" name="review_rating" class="form-control" required>
                            <option value="5">5 - Excellent</option>
                            <option value="4">4 - Very Good</option>
                            <option value="3">3 - Good</option>
                            <option value="2">2 - Fair</option>
                            <option value="1">1 - Poor</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </form>
            </div>
            <div class="col-md-6">
                <h1>Recent Reviews</h1>
                <!-- Display Recent Reviews -->
                <?php
                // Fetch recent reviews for the place including place_name
                if (isset($_GET['place_id'])) {
                    require_once "dbconnect.php";

                    $place_id = $_GET['place_id'];
                    $query = "SELECT r.*, p.place_name FROM reviews r 
                              LEFT JOIN places p ON r.place_id = p.place_id 
                              WHERE r.place_id = $place_id 
                              ORDER BY r.reviewDate DESC 
                              LIMIT 5";
                    $result = mysqli_query($conn, $query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<div class='card mb-3'>";
                            echo "  <div class='card-body'>";
                            echo "      <h5 class='card-title'>" . htmlspecialchars($row['review_title']) . "</h5>";
                            echo "      <h5 class='card-title'>Place Name: " . htmlspecialchars($row['place_name']) . "</h5>";
                            echo "      <p class='card-text'><strong>By:</strong> " . htmlspecialchars($row['user_name']) . "</p>";
                            echo "      <p class='card-text'><strong>Rating:</strong> " . htmlspecialchars($row['review_rating']) . "</p>";
                            echo "      <p class='card-text'>" . htmlspecialchars($row['review_text']) . "</p>";
                            echo "      <p class='card-text'><small class='text-muted'>" . htmlspecialchars($row['reviewDate']) . "</small></p>";
                            echo "  </div>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No reviews found for this place.</p>";
                    }

                    // Close database connection
                    mysqli_close($conn);
                } else {
                    echo "<p>No place selected.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
