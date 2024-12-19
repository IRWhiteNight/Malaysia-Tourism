<!DOCTYPE html>
<html class="htmlbody">
<head>
    <style>
        .footerbody, .htmlbody {
            margin: 0;
            padding: 0;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .contentfooter {
            flex: 1; /* This makes sure the content area takes up all the space between the header and footer */
        }
        .footer1 {
            background-color: rgb(0, 0, 0);
            border-top: 2px solid rgb(0, 183, 255);
            color: white;
            width: 100%;
            padding: 10px 0; /* Add some padding for better visual appearance */
            text-align: center;
            position: relative;
            font-family: Arial, Helvetica, sans-serif;
        }
        .footerp {
            padding-top: 50px;
            padding-bottom: 5px;
            color: rgb(0, 183, 255);
            font-size: 20px;
            margin: 0; /* Ensure no extra margin is added */
        }
        .hrfooter {
            border: none;
            border-top: 2px solid rgb(0, 183, 255); /* Adjust color and style as needed */
            width: 100%;
            margin: 20px auto; /* Adjust margins as needed */
        }
    </style>
</head>
<body class="footerbody">
    <div class="contentfooter">

    </div>
    <footer>
        <div class="footer1">
            <img src="img/logosirkhairul-01.png" style="width:10%;margin-bottom:-30px">
            <p class="footerp">Enhance Your Tour &#8482;</p>
            <p class="">VoyageView&#8482;</p>
            <hr class="hrfooter">
            <p>Copyright &#169; 2024 VoyageView. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
