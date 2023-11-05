<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style/login.css">
</head>

<body>
    <h2>Admin login site</h2>
    <div class="container" id="container">

        <div class="form-container sign-in-container">
            <?php if (!isset($_COOKIE["username"])): ?>
                <form action="#" method="post">
                    <h1>Login</h1>
                    <input type="text" name="username" placeholder="Username" />
                    <input type="password" name="password" placeholder="Password" />
                    <button type="submit" name="login">Login</button>
                </form>
            <?php else: ?>
                <form action="logout.php" method="post">
                    <h1>Welcome,
                        <?php echo $_COOKIE["username"]; ?>
                        click below to logout
                    </h1>
                    <a href="index.php"><button class="ghost" id="signUp">home</button></a>
                    <button type="submit" name="logout">Logout</button>
                </form>
            <?php endif; ?>
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

</html>

<?php
if (isset($_COOKIE["username"])) {
    $username = $_COOKIE["username"];
} else {
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Create an array with the data to send in the POST request
        $data = array(
            'username' => $username,
            'password' => $password
        );

        // Convert the data array to JSON
        $json_data = json_encode($data);

        // Set the URL for the API endpoint
        $url = 'http://localhost:8080/auth/v1/login';

        // Initialize cURL session
        $ch = curl_init($url);

        // Set cURL options for the POST request
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the cURL request
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
        } else {
            // Handle the API response (e.g., display it or process it)
            if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200) {
                echo '<script>document.getElementById("greeting").innerHTML = "WELCOME ' . $username . '";</script>';
                // Set a cookie with the username
                setcookie("username", $username, time() + 3600, "/"); // Adjust the expiration time as needed

                // Redirect to a welcome page or perform other actions
                header("Location: index.php"); // Change "welcome.php" to the desired page
                exit();
            }
        }


        // Close the cURL session
        curl_close($ch);
    }
}

?>