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
        .review-form-container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 20px; 
            z-index: 100;
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
            overflow-y: auto; 
            max-height: calc(100vh - 140px);
            margin-top: 20px;
        }
        .review-list h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .review-item {
            margin-bottom: 15px;
        }
        .imgdesign {
            width: 100%;
        }
        .but{
            margin-left:20px;
        }
        .star-rating {
            display: flex;
            flex-direction: row-reverse; 
            justify-content: center;
        }

        .star-rating input {
            display: none; 
        }

        .star-rating label {
            font-size: 30px;
            color: #ccc;
            cursor: pointer;
        }

        .star-rating label:hover,
        .star-rating label:hover ~ label,
        .star-rating input:checked ~ label {
            color: #ffcc00; 
        }
        .star-rating .star-yellow {
            color: #ffcc00; 
        }

    </style>
</head>
<?php include "header.php"?>
<body>
<a class="btn btn-primary but" href="index.php">Back</a>

    <div class="container mt-4">


    
        <div class="row">
            <div class="col-md-7">
            <?php
$place_name = "Submit a Review";
$place_img = ""; 
$averageRating = 0;

if (isset($_GET['place_id'])) {
    require_once "dbconnect.php";

    $place_id = $_GET['place_id'];
    
    // Query to fetch place details
    $queryPlace = "SELECT place_name, place_img FROM places WHERE place_id = $place_id";
    $resultPlace = mysqli_query($conn, $queryPlace);

    if ($resultPlace && mysqli_num_rows($resultPlace) > 0) {
        $rowPlace = mysqli_fetch_assoc($resultPlace);
        $place_name = htmlspecialchars($rowPlace['place_name']);
        $place_img = htmlspecialchars($rowPlace['place_img']);
    } else {
        $place_name = "Place Not Found";
    }

    // Query to calculate average rating for the specific place_id
    $queryRating = "SELECT AVG(review_rating) AS avg_rating FROM reviews WHERE place_id = $place_id";
    $resultRating = mysqli_query($conn, $queryRating);

    if ($resultRating && mysqli_num_rows($resultRating) > 0) {
        $rowRating = mysqli_fetch_assoc($resultRating);
        $averageRating = round($rowRating['avg_rating'], 1);
    } else {
        $averageRating = 0; // Default if no reviews found
    }

    // Free results and do not close $conn here
    mysqli_free_result($resultPlace);
    mysqli_free_result($resultRating);
    // mysqli_close($conn); // Do not close $conn here if you need to perform more queries

} else {
    $review_rating = "Rating Not Found";
}

echo '<h3>Average Rating: ' . getStarRating($averageRating) . ' (' . $averageRating . ')</h3>';
?>

                <img src="<?php echo $place_img; ?>" class="img-fluid mb-3 imgdesign" alt="Place Image">
                <div class="review-form-container">
                    <h1><?php echo htmlspecialchars($place_name); ?>'s Review</h1>
                    <form method="POST">
                        <input type="hidden" id="place_id" name="place_id" class="form-control" value="<?php echo htmlspecialchars($place_id); ?>">
                        <div class="form-group">
                            <label for="review_title">Review Title:</label>
                            <input type="text" id="review_title" name="review_title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="user_name">User Name:</label>
                            <input type="text" id="user_name" name="user_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="review_text">Review Text:</label>
                            <textarea id="review_text" name="review_text" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="review_rating">Review Rating:</label>
                            <div class="star-rating">
                                <input type="radio" id="star5" name="review_rating" value="5" required>
                                <label for="star5">&#9733;</label>
                                <input type="radio" id="star4" name="review_rating" value="4">
                                <label for="star4">&#9733;</label>
                                <input type="radio" id="star3" name="review_rating" value="3">
                                <label for="star3">&#9733;</label>
                                <input type="radio" id="star2" name="review_rating" value="2">
                                <label for="star2">&#9733;</label>
                                <input type="radio" id="star1" name="review_rating" value="1">
                                <label for="star1">&#9733;</label>
                            </div>
                        </div>


                        <button type="submit" name="submit" class="btn btn-primary btn-block">Submit Review</button>
                    </form>
                </div>
            </div>
            <div class="col-md-5">
                <div class="review-list">
                    <h2>Reviews</h2>
                    <?php
                    if (isset($_GET['place_id'])) {
                        require_once "dbconnect.php";

                        $place_id = $_GET['place_id'];
                        $query = "SELECT * FROM reviews WHERE place_id = $place_id ORDER BY reviewDate DESC LIMIT 5";
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<div class="review-item">';
                                echo '<h4><strong>Title:</strong> ' . htmlspecialchars($row['review_title']) . '</h4>';
                                echo '<p><strong>Name:</strong> ' . htmlspecialchars($row['user_name']) . '</p>';
                                echo '<p><strong>Rating:</strong> ' . getStarRating($row['review_rating']) . '</p>'; 
                                echo '<p><strong>Review:</strong>' . htmlspecialchars($row['review_text']) . '</p>';
                                $reviewDate = date('d/m/Y', strtotime($row['reviewDate']));
                                echo '<p><strong>Date:</strong>' . htmlspecialchars($reviewDate) . '</p>';
                                                                echo '<hr>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p>No reviews found for this place.</p>';
                        }

                        mysqli_close($conn);
                    } else {
                        echo '<p>No place selected.</p>';
                    }
                    function getStarRating($rating) {
                        $stars = '';
                        for ($i = 0; $i < $rating; $i++) {
                            $stars .= '&#9733;'; 
                        }
                        return $stars;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        $url = "http://localhost/example/review_create_api.php";

        $ch = curl_init($url);

        $data = array(
            'place_id' => $_POST['place_id'],
            'user_name' => $_POST['user_name'],
            'review_title' => $_POST['review_title'],
            'review_text' => $_POST['review_text'],
            'review_rating' => $_POST['review_rating']
        );

        $payload = json_encode($data);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

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
<script>
    // Add this script inside <script> tags in <head> or at the end of <body>
document.addEventListener('DOMContentLoaded', function() {
    let stars = document.querySelectorAll('.star-rating input');

    stars.forEach(function(star) {
        star.addEventListener('change', function() {
            resetStarColors();
            let checked = this;
            let label = checked.nextElementSibling;
            while (label) {
                label.style.color = '#ffcc00';
                label = label.nextElementSibling;
            }
        });
    });

    function resetStarColors() {
        let labels = document.querySelectorAll('.star-rating label');
        labels.forEach(function(label) {
            label.style.color = '#ccc';
        });
    }
});
</script>
</body>
</html>
