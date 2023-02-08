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
        // Check if the cache file exists and if it is less than 24 hours old
        $cache_file = "movie_titles.cache";
        if (file_exists($cache_file) && time() - filemtime($cache_file) < 86400) {
            $titles = unserialize(file_get_contents($cache_file));
        } else {
            $api_url = "http://www.omdbapi.com/?apikey=70d187f6&s=movie&type=movie";
            $response = file_get_contents($api_url);
            $movies = json_decode($response, true);
            if ($movies["Response"] == "True") {
                $titles = array();
                foreach ($movies["Search"] as $movie) {
                    $titles[] = $movie["Title"];
                }
                file_put_contents($cache_file, serialize($titles));
            } else {
                echo "No movie titles found in the API.";
                exit();
            }
        }

        $random_index = array_rand($titles);
        $random_title = $titles[$random_index];

        // Check if the movie poster image exists locally
        $poster_file = "posters/" . urlencode($random_title) . ".jpg";
        if (!file_exists($poster_file)) {
            $api_url = "http://www.omdbapi.com/?apikey=70d187f6&t=" . urlencode($random_title);
            $response = file_get_contents($api_url);
            $movie = json_decode($response, true);
            if ($movie["Response"] == "True") {
                $poster_url = $movie["Poster"];
                file_put_contents($poster_file, file_get_contents($poster_url));
            }
        }

        echo "<p>Your random movie title is: <b>" . $random_title . "</b></p>";
        echo "<img class='poster' src='" . $poster_file . "' alt='" . $random_title . " poster'>";
    }
    ?>
</body>
</html>