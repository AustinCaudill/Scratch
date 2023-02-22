<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Random Movie Generator</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style type="text/css">
        body {
            font-family: Roboto, sans-serif;
            background-color: #e0e0e0;
            padding: 50px;
            text-align: center;
        }
        h1 {
            font-size: 50px;
            margin-bottom: 20px;
        }
        .movie-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: stretch;
        }
        .movie {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin: 20px;
            overflow: hidden;
            width: 300px;
            flex: 0 0 auto;
        }
        .movie-poster {
            height: 400px;
            overflow: hidden;
            position: relative;
        }
        .movie-poster img {
            height: 100%;
            left: 0;
            position: absolute;
            top: 0;
            width: 100%;
        }
        .movie-title {
            color: #3f51b5;
            font-size: 20px;
            font-weight: bold;
            margin: 10px;
            text-align: center;
            text-transform: uppercase;
        }
        .movie-overview {
            font-size: 14px;
            margin: 10px;
            text-align: justify;
        }
        .slick-prev, .slick-next {
            font-size: 0;
            line-height: 0;
            position: absolute;
            top: 50%;
            display: block;
            width: 20px;
            height: 20px;
            padding: 0;
            transform: translate(0, -50%);
            cursor: pointer;
            color: transparent;
            border: none;
            outline: none;
            background: transparent;
        }
        .slick-prev:before, .slick-next:before {
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            font-size: 20px;
            line-height: 1;
            color: #ccc;
            opacity: 0.75;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .slick-prev {
            left: -40px;
        }
        .slick-next {
            right: -40px;
        }
        .movie-list::-webkit-scrollbar {
            display: none;
        }
        .generate-button {
            background-color: #3f51b5;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
            padding: 10px
        }
        .generate-button:hover {
            background-color: #2c3e50;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Random Movie Generator</h1>
    <div class="movie-list"></div>
    <button class="generate-button">Generate New Movies</button>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.generate-button').click(function() {
                $('.movie-list').empty();
                for (let i = 0; i < 5; i++) {
                    getMovie();
                }
            });

            function getMovie() {
                const apiKey = 'e0ee788e1d40aa09d5e67c0226b67a32';
                let movieId = Math.floor(Math.random() * 1000000);
                $.ajax({
                    url: `https://api.themoviedb.org/3/movie/${movieId}?api_key=${apiKey}`,
                    success: function(result) {
                        if (result.original_language === 'en' && result.adult === false) {
                            displayMovie(result);
                        } else {
                            getMovie();
                        }
                    },
                    error: function() {
                        getMovie();
                    }
                });
            }

            function displayMovie(movie) {
                const imageUrl = `http://image.tmdb.org/t/p/w500${movie.poster_path}`;
                const title = movie.title;
                const overview = movie.overview;
                const $movie = $('<div>').addClass('movie');
                const $moviePoster = $('<div>').addClass('movie-poster');
                const $moviePosterImg = $('<img>').attr('src', imageUrl);
                const $movieTitle = $('<div>').addClass('movie-title').text(title);
                const $movieOverview = $('<div>').addClass('movie-overview').text(overview);
                $moviePoster.append($moviePosterImg);
                $movie.append($moviePoster, $movieTitle, $movieOverview);
                $('.movie-list').append($movie);
                $('.movie-list').slick('unslick').slick({
                    slidesToShow: 5,
                    slidesToScroll: 5,
                    dots: true,
                    arrows: true,
                    prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>',
                    nextArrow: '<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>'
                });
            }
        });
    </script>
</body>
</html>