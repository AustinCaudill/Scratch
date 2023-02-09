<!DOCTYPE html>
<html>
  <head>
    <title>Random Movie</title>
    <style>
      body {
        background-color: lightgray;
        font-family: Arial, sans-serif;
      }
      .container {
        background-color: white;
        width: 80%;
        margin: 50px auto;
        padding: 50px;
        box-shadow: 0px 0px 10px black;
      }
      h1 {
        text-align: center;
        color: red;
        font-size: 40px;
      }
      img {
        display: block;
        margin: 0 auto;
      }
      p {
        font-size: 20px;
        text-align: center;
        margin-top: 20px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <?php include 'jpam2.php'; ?>
      <button onclick="window.location.reload()">Generate New Movie</button>
    </div>
  </body>
</html>