<?php

define("API_KEY", "e0ee788e1d40aa09d5e67c0226b67a32");

// Function to get the latest movie id
function getLatestMovieId($api_key) {
    $url = "https://api.themoviedb.org/3/movie/latest?api_key=" . $api_key;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($response, true);
    return $response["id"];
}

// Function to get movie details for a specific movie id
function getMovieDetails($movie_id, $api_key) {
    $url = "https://api.themoviedb.org/3/movie/" . $movie_id . "?api_key=" . $api_key;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($response, true);
    return $response;
}

$api_key = API_KEY;
$latest_movie_id = getLatestMovieId($api_key);

// Check if the API returned the latest movie id
if ($latest_movie_id) {
    do {
        $random_movie_id = rand(0, $latest_movie_id);
        $movie_details = getMovieDetails($random_movie_id, $api_key);
    } while (!$movie_details || $movie_details["adult"] || !($movie_details["original_language"] == "en") || !(date("Y", strtotime($movie_details["release_date"])) >= date("Y") - 10));
}

// Display movie details
echo "Movie Title: " . $movie_details["title"] . "\n";
echo "Movie Overview: " . $movie_details["overview"] . "\n";
echo "Movie Poster: " . "<img src='https://image.tmdb.org/t/p/w500" . $movie_details["poster_path"] . "'>" . "\n";

?>