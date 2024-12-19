<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Ratings</title>
    <style>
        /* CSS for star rating display */
        .stars {
            display: inline-block;
            unicode-bidi: bidi-override;
            color: #007bff;
            font-size: 20px;
            height: 20px;
            width: auto;
            margin-left: 5px;
            position: relative;
        }

        .stars::before {
            content: "★★★★★";
            position: absolute;
            z-index: -1;
            top: 0;
            left: 0;
            overflow: hidden;
            color: #ccc;
        }

        .stars span {
            display: inline-block;
            position: absolute;
            top: 0;
            left: 0;
            overflow: hidden;
            white-space: nowrap;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2>Reviews</h2>

        <?php
        $DBhost = "localhost";
        $DBuser = "root";
        $DBpassword ="";
        $DBname="ict651project";
        
        $conn = mysqli_connect($DBhost, $DBuser, $DBpassword, $DBname); 

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Query to fetch all reviews and calculate average rating
        $query = "SELECT AVG(review_rating) AS avg_rating FROM reviews";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $averageRating = round($row['avg_rating'], 1);
        } else {
            $averageRating = 0; // Default if no reviews are found
        }

        // Function to generate star ratings based on average rating
        function generateStars($rating) {
            $stars = '';
            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $rating) {
                    $stars .= '<span>★</span>';
                } else {
                    $stars .= '<span>☆</span>';
                }
            }
            return $stars;
        }

        // Display average rating with stars
        echo '<h3>Average Rating: ' . generateStars($averageRating) . ' (' . $averageRating . ')</h3>';

        // Query to fetch all reviews
        $query_reviews = "SELECT * FROM reviews";
        $result_reviews = mysqli_query($conn, $query_reviews);

        if (mysqli_num_rows($result_reviews) > 0) {
            while ($row_review = mysqli_fetch_assoc($result_reviews)) {
                $reviewTitle = htmlspecialchars($row_review['review_title']);
                $userName = htmlspecialchars($row_review['user_name']);
                $reviewText = htmlspecialchars($row_review['review_text']);
                $reviewRating = $row_review['review_rating'];
                $reviewDate = date('d/m/Y', strtotime($row_review['reviewDate']));

                // Display each review with its rating and other details
                echo '<div class="review-item">';
                echo '<h4><strong>Title:</strong> ' . $reviewTitle . '</h4>';
                echo '<p><strong>Name:</strong> ' . $userName . '</p>';
                echo '<p><strong>Rating:</strong> ' . generateStars($reviewRating) . '</p>';
                echo '<p><strong>Review:</strong> ' . $reviewText . '</p>';
                echo '<p><strong>Date:</strong> ' . $reviewDate . '</p>';
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
</body>
</html>
