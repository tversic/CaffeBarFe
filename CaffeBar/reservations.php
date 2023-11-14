<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article</title>
    <link rel="stylesheet" href="style/article.css">
</head>

<body>
    <?php
    $url = 'http://localhost:8080/reservation/v1/getNotApproved';
    $reservationsJson = file_get_contents($url);
    $reservations = json_decode($reservationsJson, true);
    ?>
    <h2>Manage reservations</h2>
    <div class="container" id="container" style="height: <?php echo count($reservations) * 60 + 480; ?>px;">
        <div class="form-container sign-in-container">
            <h1 style="text-align: center">Reservations waiting for approval</h1>

            <?php
            // Call the API and display the results
            $apiUrl = 'http://localhost:8080/reservation/v1/getNotApproved';
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

                        echo '<hr><h5 style="padding: 3px;">' .
                            ' Name: ' . $data[$i]['firstName'] . ' <div class="vertical-line"></div>' .
                            ' Surname: ' . $data[$i]['lastName'] . ' ' . ' <div class="vertical-line"></div>' .
                            ' Email: ' . $data[$i]['email'] . ' ' . ' <div class="vertical-line"></div>' .
                            ' Date: ' . $formattedDate . ' </h5>' .
                            '<button onclick="approveReservation(' . $data[$i]['reservationId'] . ')">Accept</button>' .
                            '<button> Deny </button>' .
                            '<hr>';

                        // Add other fields as needed
                    }
                } else {
                    echo '<p>No reservations waiting for approval</p>';
                }
            } else {
                echo '<p>Failed to fetch reservations. Error: ' . error_get_last()['message'] . '</p>';
            }
            ?>


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

    <footer>
        <p>
            Tome Versic 2023
        </p>
    </footer>
</body>
<script>
    function approveReservation(reservationId) {
        console.log("Approve reservation ", reservationId);
        const reservationData = {
            "reservationId": reservationId,
        };

        // Make a fetch request to the approveReservation endpoint
        fetch('http://localhost:8080/reservation/v1/approveReservation', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(reservationData),
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                // Reload the page or update the UI as needed
                location.reload();
            })
            .catch(error => console.error('Error:', error));
    }
</script>


</html>