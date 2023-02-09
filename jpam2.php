<?php

$apikey = "70d187f6";
$page = rand(1, 100);
$cache_file = "omdb_cache.txt";
$cache_expiration = 3600; // 1 hour
$log_file = "omdb_log.txt";

$word = "alien";


if (file_exists($cache_file) && time() - $cache_expiration < filemtime($cache_file)) {
  // If cache file exists and is still fresh, use it
  $data = file_get_contents($cache_file);

   // Log the cache file use in the log file
   file_put_contents($log_file, date('Y-m-d H:i:s') . ": Cache file used\n", FILE_APPEND);
} else {
  // If cache file does not exist or is stale, fetch new data from the API
  $url = "http://www.omdbapi.com/?apikey=" . $apikey . "&s=" . $word . "&type=movie&r=json&page=" . $page;

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

  $data = curl_exec($ch);
  curl_close($ch);

  // Store the fetched data in a cache file for future use
  file_put_contents($cache_file, $data);
  
  // Log the API call in the log file
  file_put_contents($log_file, date('Y-m-d H:i:s') . ": API call made\n", FILE_APPEND);
}

$movies = json_decode($data, true);
$movies = $movies['Search'];

// Select a random movie from the cache file
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

?>
