<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent</title>
    <link rel="stylesheet" href="style/article.css">
    <link rel="stylesheet" href="style/weather.css">
    <link rel="stylesheet" href="style/rentBaia.css">


    <script>
        function showAlertAndRedirect() {
            console.log("success");
            // No need for the alert, just show the success window
            alert("Your reservation is saving successfully");
            // Redirect after a short delay
            window.location.href = 'rentBaia.php';
        }

        function showBadAlertAndRedirect() {
            console.log("fail");
            // No need for the alert, just show the success window
            alert("Your reservation failed");
            // Redirect after a short delay
            setTimeout(function () {
                window.location.href = 'rentBaia.php';
            }, 2000); // Adjust the delay time as needed (in milliseconds)
        }
    </script>
</head>

<body>
    <?php
    $errors = [];

    if (isset($_POST['reserve'])) {

        // Validate form fields
        if (empty($_POST['firstName'])) {
            $errors[] = 'First name is required.';
        }

        if (empty($_POST['lastName'])) {
            $errors[] = 'Last name is required.';
        }

        if (empty($_POST['email'])) {
            $errors[] = 'Email is required.';
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format.';
        }

        if (empty($_POST['reservationDate'])) {
            $errors[] = 'Date is required.';
        }

        echo '<script>';
        echo 'console.log(' . json_encode($errors) . ')';
        echo '</script>';

        // If there are no validation errors, process the form data
        if (empty($errors)) {
            handleFormSubmission();
            // Redirect to prevent form resubmission on page refresh
            exit();
        }
    }

    // Initialize cURL session
    $ch = curl_init();

    // Set the cURL options
    curl_setopt($ch, CURLOPT_URL, 'http://localhost:8080/v1/weather'); // API endpoint URL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
    curl_setopt($ch, CURLOPT_HTTPGET, true); // Use HTTP GET method
    
    // Execute the cURL request
    $response = curl_exec($ch);
    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'cURL error: ' . curl_error($ch);
    } else {
        // Display the API response
    
        // Decode the JSON response
        $data = json_decode($response, true);

        // Extract the data you want
        $cityName = $data['location']['name'];
        $localTime = date('H:i', strtotime($data['location']['localtime'])); // Format as hours:minutes
        $currentDate = date('Y/m/d', strtotime($data['current']['last_updated'])); // Format as yyyy/mm/dd
        $tempC = $data['current']['temp_c'];
        $windKph = $data['current']['wind_kph'];
        $percipMM = $data['current']['precip_mm'];
    }

    // Close the cURL session
    curl_close($ch);
    ?>
    <h2>RENT BAIA</h2>
    <div id="weather" style="margin-bottom: 5%;">
        <div id="weather_wrapper">
            <div class="weatherCard">
                <div class="currentTemp">
                    <span class="temp">
                        <?php echo $tempC ?>&deg;
                    </span>
                    <span class="location">
                        <?php echo $cityName ?>
                    </span>
                </div>
                <div class="currentWeather">
                    <span class="conditions">&#xf00d;</span>
                    <div class="info">
                        <span class="rain">
                            <?php echo $percipMM ?> MM
                        </span>
                        <span class="wind">
                            <?php echo $windKph ?> KPH
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container" id="container" style="margin-bottom: 2%;">
        <div class="form-container sign-in-container">
            <form action="" method="post">
                <h1>Fill in form</h1>
                <input type="text" name="firstName" placeholder="Enter first name" />
                <?php if (in_array('First name is required.', $errors)): ?>
                    <div style="color: red;">
                        <?php echo 'First name is required.' ?>
                    </div>
                <?php endif; ?>


                <input type="text" name="lastName" placeholder="Enter last name" />
                <?php if (in_array('Last name is required.', $errors)): ?>
                    <div style="color: red;">
                        <?php echo 'Last name is required.' ?>
                    </div>
                <?php endif; ?>


                <!--EMAIL AND VALIDATION -->
                <input type="text" name="email" placeholder="Enter email address" />
                <?php if (in_array('Invalid email format.', $errors)): ?>
                    <div style="color: red;">
                        <?php echo 'Invalid email format.' ?>
                    </div>
                <?php endif; ?>
                <?php if (in_array('Email is required.', $errors)): ?>
                    <div style="color: red;">
                        <?php echo 'Email is required.' ?>
                    </div>
                <?php endif; ?>

                <input type="date" name="reservationDate" placeholder="Select date you want to rent a baia" />
                <?php if (in_array('Date is required.', $errors)): ?>
                    <div style="color: red;">
                        <?php echo 'Date is required.' ?>
                    </div>
                <?php endif; ?>


                <button type="submit" name="reserve">Reserve</button>
            </form>
            <div id="success-message">
                <p> RESERVATION SENT SUCCESSFULLY! </p>
            </div>

        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-right">
                    <h1 id="greeting">GET ME TO HOME SITE!</h1>
                    <a href="index.php"><button class="ghost" id="signUp">home</button></a>
                </div>
            </div>
        </div>
    </div>

    <div class="container" id="container" style="margin-bottom: 2%;">
        <h3 style="text-align: center;">List of taken days</h3>
        <?php
        $apiUrl = 'http://localhost:8080/reservation/v1/getAllApproved';
        $response = @file_get_contents($apiUrl);

        if ($response !== false) {
            $data = json_decode($response, true);

            // Debugging: Output the decoded data to see what the API returned
            /*echo '<pre>';
            print_r($data);
            echo '</pre>';*/


            if ($data !== null) {
                for ($i = 0; $i < sizeof($data); $i++) {
                    $reservationDate = new DateTime($data[$i]['reservationDate']);
                    $formattedDate = $reservationDate->format('d-m-Y');

                    echo '<hr><h3 style="padding: 3px; text-align: center;">' .
                        ' Name: ' . $data[$i]['firstName'] . ' <div class="vertical-line"></div>' .
                        ' Surname: ' . $data[$i]['lastName'] . ' ' . ' <div class="vertical-line"></div>' .
                        ' Email: ' . $data[$i]['email'] . ' ' . ' <div class="vertical-line"></div>' .
                        ' Date: ' . $formattedDate . ' </h3>' .
                        '<hr>';

                    // Add other fields as needed
                }
            } else {
                echo '<p>No approved reservations</p>';
            }
        } else {
            echo '<p>Failed to fetch reservations. Error: ' . error_get_last()['message'] . '</p>';
        }


        ?>
    </div>

    <div id="success-window" style="display: none;">
        <p>Reservation sent successfully! Please wait for a response on your email.</p>
    </div>

    <footer>
        <p>
            Tome Versic 2023
        </p>
    </footer>

</body>

</html>
<?php
function handleFormSubmission()
{
    $firstname = $_POST['firstName'];
    $lastname = $_POST['lastName'];
    $email = $_POST['email'];
    $date = $_POST['reservationDate'];

    $data = array(
        'firstName' => $firstname,
        'lastName' => $lastname,
        'email' => $email,
        'reservationDate' => $date
    );

    $json_data = json_encode($data);
    $url = 'http://localhost:8080/reservation/v1/save';

    // Initialize cURL session
    $ch = curl_init($url);


    // Set cURL options for the POST request
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Execute the cURL request
    curl_exec($ch); // HOW TO CHECK IF THIS RESPONSE IS NO CONTENT OR 200 OK 
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($httpCode === 200) {
        // Success
        echo
            '<script>
            showAlertAndRedirect();
        </script>';
    } else {
        echo '<script>
        showBadAlertAndRedirect();
        window.location.href = "rentBaia.php";
        </script>';
        // Handle other status codes
        error_log('Error: HTTP ' . $httpCode);
    }
    // Close the cURL session
    curl_close($ch);
    /* echo '<script>
         alert("Reservation sent successfully! Please wait for a response on your email.");
         window.location.href = "rentBaia.php";
     </script>';*/
}




?>