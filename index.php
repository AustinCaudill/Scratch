<!DOCTYPE html>
<html>
  <head>
    <title>Just Pick A Movie - Your Ultimate Movie Decision Maker</title>
    <meta name="description" content="Can't decide what movie to watch? Just Pick A Movie makes it easy for indecisive movie lovers to find their next movie. Try it now.">
    <meta name="keywords" content="movies, movie selection, movie recommendation, random movie, pick a movie, indecisive">
    <meta property="og:title" content="Just Pick A Movie - Your Ultimate Movie Decision Maker">
    <meta property="og:description" content="Can't decide what movie to watch? Just Pick A Movie makes it easy for indecisive movie lovers to find their next movie. Try it now.">
    <meta property="og:image" content="[path to image file]">
    <meta property="og:url" content="[website URL]">
    <script type="application/ld+json">
        {
        "@context": "http://schema.org",
        "@type": "WebSite",
        "name": "Just Pick A Movie",
        "url": "[website URL]",
        "description": "Can't decide what movie to watch? Just Pick A Movie makes it easy for indecisive movie lovers to find their next movie. Try it now.",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "[website URL]?q={q}",
            "query-input": "required name=q"
        }
        }
    </script>
    <link rel="stylesheet" type="text/css" href="stylesheet-movie.css">
  </head>
  <body>
    <div class="container">
      <?php include 'jpam2.php'; ?>
      <h1><?php echo $random_movie['Title']; ?></h1>
      <img src="<?php echo $poster; ?>" alt="<?php echo $random_movie['Title']; ?>">
      <p><?php echo $synopsis; ?></p>
      <div class="share">
        <a href="sms:&body=Check out this movie: <?php echo $random_movie['Title'] ?> - <?php echo $synopsis ?>">Send as Text</a>
        <a href="sms:&body=Check out this movie: <?php echo $random_movie['Title'] ?> - <?php echo $synopsis ?>">Send as iMessage</a>
      </div>
      <button onclick="window.location.reload()">Generate New Movie</button>
    </div>
  </body>
</html>