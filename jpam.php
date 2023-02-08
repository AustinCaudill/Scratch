<html>
<head>
    <title>Random Movie Title Generator</title>
</head>
<body>
    <form action="" method="post">
        <input type="submit" name="generate_title" value="Generate Movie Title">
    </form>
    <?php
    if (isset($_POST["generate_title"])) {
        $api_url = "http://www.omdbapi.com/?apikey=your_api_key&s=movie&type=movie";

        $response = file_get_contents($api_url);
        $movies = json_decode($response, true);

        if ($movies["Response"] == "True") {
            $titles = array();
            foreach ($movies["Search"] as $movie) {
                $titles[] = $movie["Title"];
            }
            $random_index = array_rand($titles);
            $random_title = $titles[$random_index];
            echo "<p>Your random movie title is: <b>" . $random_title . "</b></p>";
        } else {
            echo "No movie titles found in the API.";
        }
    }
    ?>
</body>
</html>