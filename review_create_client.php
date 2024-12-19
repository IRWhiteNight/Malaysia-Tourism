<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit a Review</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .review-form {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .review-form h1 {
            margin-bottom: 20px;
            text-align: center;
        }
        .review-form .form-group {
            margin-bottom: 15px;
        }
        .review-form label {
            font-weight: bold;
        }
        .review-form .btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .review-form .btn:hover {
            background-color: #0056b3;
        }
        .review-list {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .review-list h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .review-item {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-7"> <!-- Adjusted col-md-7 to make form section slightly smaller -->
                <div class="review-form">
                    <h1>Review For </h1>
                    <form method="POST">
                        <div class="form-group">
                            <label for="place_id">Place ID:</label>
                            <input type="text" id="place_id" name="place_id" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="user_name">User Name:</label>
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
                        <button type="submit" name="submit" class="btn btn-primary btn-block">Submit Review</button>
                    </form>
                </div>
            </div>
            <div class="col-md-5"> <!-- Adjusted col-md-5 to make review list section slightly larger -->
                <div class="review-list">
                    <h2>Reviews</h2>
                    <?php
                    // Fetch reviews from database
                    require_once "dbconnect.php";

                    $query = "SELECT * FROM reviews ORDER BY reviewDate DESC LIMIT 5";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="review-item">';
                            echo '<h4>' . htmlspecialchars($row['review_title']) . '</h4>';
                            echo '<p><strong>Name:</strong> ' . htmlspecialchars($row['user_name']) . '</p>';
                            echo '<p><strong>Rating:</strong> ' . htmlspecialchars($row['review_rating']) . '</p>';
                            echo '<p><strong>Review:</strong>' . htmlspecialchars($row['review_text']) . '</p>';
                            echo '<p><strong>Date:</strong>' . htmlspecialchars($row['reviewDate']) . '</p>';
                            echo '<hr>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No reviews found.</p>';
                    }

                    // Close database connection
                    mysqli_close($conn);
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        // Specify the URL where the JSON data is to be sent
        $url = "http://localhost/example/review_create_api.php";

        // Initialize new cURL resource
        $ch = curl_init($url);

        // Setup request to send JSON via POST
        $data = array(
            'place_id' => $_POST['place_id'],
            'user_name' => $_POST['user_name'],
            'review_title' => $_POST['review_title'],
            'review_text' => $_POST['review_text'],
            'review_rating' => $_POST['review_rating']
        );

        // Encode data into JSON
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

        // Display result
        echo '<div class="container mt-4">';
        echo '<div class="alert alert-info">';
        echo '<p>Receiving data from review client to review create API: ';
        var_dump($result);
        echo '</p>';
        echo '</div>';
        echo '<a href="http://localhost/example/review_list_client.php" class="btn btn-primary">Back</a>';
        echo '</div>';
    }
    ?>

</body>
</html>
