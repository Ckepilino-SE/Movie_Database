<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="styles.css">
  <meta charset="UTF-8">
  <title>Rate Movie - DataFlix</title>
</head>
<body>
  <header class="header">
    <a href="#default" class="logo">DataFlix</a>
    <div class="header-right">
      <a href="index.php">Home</a>
      <a href="search_movies.php">Search Movies</a>
      <a href="favorites.php">My Favorites</a>
      <a href="user_profile.php">My Profile</a>
      <?php if (isset($_SESSION['user'])): ?>
        <a href="logout.php">Logout</a>
      <?php else: ?>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
      <?php endif; ?>
    </div>  
  </header>

  <main>
    <?php if (!isset($_SESSION['user'])): ?>
      <p>Please <a href="login.php">login</a> to rate movies.</p>
    <?php else: ?>
    <form method="post">
      <fieldset>
        <legend>Movie Information</legend>
        <div>
          <label for="movie_title">Movie Title:</label>
          <input type="text" id="movie_title" name="movie_title" required>
        </div>
      </fieldset>

      <fieldset>
        <legend>Your Rating & Review</legend>

        <div>
          <label for="rating">Rating (0-10):</label>
          <input type="number" id="rating" name="rating" min="0" max="10" step="0.1" required>
        </div>

        <div>
          <label for="review_text">Review (optional):</label><br>
          <textarea id="review_text" name="review_text" rows="5" cols="40"></textarea>
        </div>
      </fieldset>

      <div>
        <button type="submit">Submit Review</button>
      </div>
    </form>
    <?php endif; ?>
  </main>

  <footer>
    <p>Group 2 - CS 4347.007</p>
  </footer>
</body>
</html>
