<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Title Here</title>
    <style>
        /* Resetting default margin and padding for body */
        body {
            margin: 0;
            padding: 0;
        }

        /* Styling for the header */
        .header {
            font-family: Arial, sans-serif;
            margin: 0; /* Remove any default margin */
        }

        .header .navbar {
            background-color: #000000;
            padding: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-bottom: 2px solid rgb(0, 183, 255);
            margin-top: 0; /* Ensure no margin at the top */
            margin-bottom: 20px;
        }

        .header .navbar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .header .nav-item {
            margin: 0 1rem;
        }

        .header .nav-item a {
            color: rgb(165, 165, 165);
            text-decoration: none;
            font-size: 15px;
            margin-left: 20px;
            margin-right: 20px;
        }

        .header .nav-item a:hover {
            color: white;
        }

        .header .imgsize {
            width: 15%;
            margin-bottom: -10px;
        }

        .header i {
            font-size: 15px;
        }

        /* Styling for the card container */
        .header .card-container {
            display: flex;
            align-items: center;
            overflow-x: auto;
            gap: 20px;
            padding: 20px;
            max-width: 70%;
            width: 100%;
            height: 350px;
            margin: auto;
            margin-top: 0; /* Ensure no margin at the top */
        }

        .header .card {
            flex: 0 0 auto;
            width: 200px;
            height: 300px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            transition: height 0.3s ease; /* Smooth height transition */
        }

        .header .card:hover {
            height: 350px; /* New height on hover */
        }

        .header .card-body {
            padding: 10px;
        }

        .header .card-title {
            font-size: 20px;
            text-align: center;
        }

        .header .size {
            width: 100%;
        }

        .header .middle {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            margin: auto;
        }
    </style>
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <ul class="navbar-nav">
                <li class="nav-item"><a href="about.php"><img class="imgsize" src="img/logosirkhairul-01.png" alt="Logo"></a></li>
            </ul>
        </nav>
    </header>

    <!-- Your content goes here -->

</body>
</html>
