<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article</title>
    <link rel="stylesheet" href="style/article.css">
</head>

<body>
    <h2>Write new article</h2>
    <div class="container" id="container">
        <div class="form-container sign-in-container">
            <form action="#" method="post">
                <h1>Write new article header</h1>
                <input type="text-box" name="header" placeholder="Header" />
                <h1>Write new article content</h1>
                <textarea type="text" name="content" placeholder="Content" cols="30" rows="10"></textarea>
                <button type="submit" name="publish">Publish</button>
            </form>
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
if (isset($_POST['publish'])) {
    $header = $_POST['header'];
    $content = $_POST['content'];

    // Create an array with the data to send in the POST request
    $data = array(
        'header' => $header,
        'content' => $content
    );

    // Convert the data array to JSON
    $json_data = json_encode($data);

    // Set the URL for the API endpoint
    $url = 'http://localhost:8080/post/v1/create';

    // Initialize cURL session
    $ch = curl_init($url);

    // Set cURL options for the POST request
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the cURL request
    $response = curl_exec($ch);
    header("Location: index.php");
    // Close the cURL session
    curl_close($ch);
}
?>