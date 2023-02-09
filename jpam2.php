<?php

$apikey = "70d187f6";
$page = rand(1, 10);
$cache_file = "omdb_cache.txt";
$cache_expiration = 3600; // 1 hour

if (file_exists($cache_file) && time() - $cache_expiration < filemtime($cache_file)) {
  // If cache file exists and is still fresh, use it
  $data = file_get_contents($cache_file);
} else {
  // If cache file does not exist or is stale, fetch new data from the API
  $url = "http://www.omdbapi.com/?apikey=" . $apikey . "&s=movie&type=movie&r=json&page=" . $page;

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

  $data = curl_exec($ch);
  curl_close($ch);

  // Store the fetched data in a cache file for future use
  file_put_contents($cache_file, $data);
}

$movies = json_decode($data, true);
$movies = $movies['Search'];

$random_key = array_rand($movies);
$random_movie = $movies[$random_key];
$movie_id = $random_movie['imdbID'];

$movie_url = "http://www.omdbapi.com/?apikey=" . $apikey . "&i=" . $movie_id;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $movie_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$movie_data = curl_exec($ch);
curl_close($ch);

$movie_details = json_decode($movie_data, true);
$poster = $movie_details['Poster'];
$synopsis = $movie_details['Plot'];

echo "<h1>Random Movie: " . $random_movie['Title'] . "</h1>";
echo "<img src='" . $poster . "' />";
echo "<p>Synopsis: " . $synopsis . "</p>";

?>