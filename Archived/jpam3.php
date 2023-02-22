<?php

ini_set('memory_limit', '1028M');

// Download the file
$url = "https://datasets.imdbws.com/title.basics.tsv.gz";
$file = "title.basics.tsv.gz";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$data = curl_exec($ch);
curl_close($ch);

file_put_contents($file, $data);

// Unzip the file
$zipped_file = gzopen($file, 'rb');
$unzipped_file = "title.basics.tsv";

file_put_contents($unzipped_file, gzread($zipped_file, filesize($file)));

gzclose($zipped_file);

// Read the unzipped file and pick a random movie title
$lines = file($unzipped_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$headers = explode("\t", $lines[0]);

$movies = array();

for ($i = 1; $i < count($lines); $i++) {
  $values = explode("\t", $lines[$i]);
  $movie = array();

  for ($j = 0; $j < count($headers); $j++) {
    $movie[$headers[$j]] = $values[$j];
  }

  if ($movie['titleType'] == 'movie') {
    $movies[] = $movie;
  }
}

$random_key = array_rand($movies);
$random_movie = $movies[$random_key];

echo "Random movie: " . $random_movie['primaryTitle'];

?>