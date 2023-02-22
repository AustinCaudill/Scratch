<?php
// The API key
$apiKey = "e0ee788e1d40aa09d5e67c0226b67a32";

// The cache file names
$movieListCacheFile = "movie_list_cache.txt";
$randomMovieCacheFile = "random_movie_cache.txt";

// A function to get a random movie
function getRandomMovie() {
  global $apiKey, $movieListCacheFile, $randomMovieCacheFile;

  // Check if the movie list cache file exists
  if (file_exists($movieListCacheFile) && (filemtime($movieListCacheFile) > (time() - 60 * 60 * 24))) {
    // If the file exists and is recent, retrieve the movie list from the cache
    $movieList = unserialize(file_get_contents($movieListCacheFile));
  } else {
    // If the file does not exist or is outdated, make an API call to retrieve the movie list
    $movieListResponse = file_get_contents("https://api.themoviedb.org/3/discover/movie?api_key=" . $apiKey . "&language=en-US&sort_by=popularity.desc&include_adult=false&include_video=false&page=1");
    if ($movieListResponse === false) {
      // If the API call fails, log the error and return false
      error_log("[ERROR] Failed to retrieve movie list");
      return false;
    }
    $movieList = json_decode($movieListResponse, true);
    file_put_contents($movieListCacheFile, serialize($movieList));
  }

  // Get the movie list from the API response
  $movies = $movieList["results"];

  // Check if the random movie cache file exists
  if (file_exists($randomMovieCacheFile)) {
    // If the file exists, retrieve the list of shown movie IDs from the cache
    $randomMovieIds = unserialize(file_get_contents($randomMovieCacheFile));
  } else {
    // If the file does not exist, create a new list of shown movie IDs
    $randomMovieIds = [];
  }

  // Get a random movie
  $randomIndex = rand(0, count($movies) - 1);
  $randomMovie = $movies[$randomIndex];

  // Ensure that the same movie is not shown twice
  while (in_array($randomMovie["id"], $randomMovieIds)) {
    $randomIndex = rand(0, count($movies) - 1);
    $randomMovie = $movies[$randomIndex];
  }

  // Add the random movie ID to the cache
  $randomMovieIds[] = $randomMovie["id"];
  file_put_contents($randomMovieCacheFile, serialize($randomMovieIds));

  // Return the random movie
  return $randomMovie;
  }
  
  // Get a random movie
  $randomMovie = getRandomMovie();
  
  // Check if a valid movie was returned
  if ($randomMovie !== false) {
  // Display the movie information
  echo "<h1>" . $randomMovie["title"] . "</h1>";
  echo "<img src='https://image.tmdb.org/t/p/w500" . $randomMovie["poster_path"] . "' alt='" . $randomMovie["title"] . " poster'>";
  echo "<p>" . $randomMovie["overview"] . "</p>";
  } else {
  // If a valid movie was not returned, display an error message
  echo "An error occurred. Please try again later.";
  }
  ?>