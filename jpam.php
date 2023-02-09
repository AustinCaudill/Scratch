<html>
<head>
    <title>Random Movie Title Generator</title>
    <style>
        .poster {
            width: 200px;
            height: 300px;
        }
    </style>
</head>
<body>
    <form action="" method="post">
        <input type="submit" name="generate_title" value="Generate Movie Title">
    </form>
    <?php
    if (isset($_POST["generate_title"])) {
        $api_url = "http://www.omdbapi.com/?apikey=70d187f6&s=movie&type=movie";
        $response = file_get_contents($api_url);
        $movies = json_decode($response, true);
        if ($movies["Response"] == "True") {
            $titles = array();
            foreach ($movies["Search"] as $movie) {
                $titles[] = $movie["Title"];
            }
        } else {
            echo "No movie titles found in the API.";
            exit();
        }

        $random_index = array_rand($titles);
        $random_title = $titles[$random_index];

        $api_url = "http://www.omdbapi.com/?apikey=70d187f6&t=" . urlencode($random_title);
        $response = file_get_contents($api_url);
        $movie = json_decode($response, true);
        if ($movie["Response"] == "True") {
            $poster_url = $movie["Poster"];
        }

        echo "<p>Your random movie title is: <b>" . $random_title . "</b></p>";
        echo "<img class='poster' src='" . $poster_url . "' alt='" . $random_title . " poster'>";
    }
    ?>
</body>
</html>
