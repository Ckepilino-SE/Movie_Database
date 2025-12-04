<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="styles.css">
  <meta charset="UTF-8">
  <title>Search Movies - DataFlix</title>
</head>
<body>
  <header class="header">
    <a href="#default" class="logo">DataFlix</a>
    <div class="header-right">
      <a href="index.php">Home</a>
      <a class="active" href="search_movies.php">Search Movies</a>
      <a href="favorites.php">My Favorites</a>
      <a href="user_profile.php">My Profile</a>
      <a href="login.php">Login</a>
    </div>  
  </header>

  <main>
    <form action="search_results.php", method="POST">
        <div>
          <label for="title">Title</label>
          <input type="text" id="title" name="title">
        </div>

        <div>
          <label for="director">Director</label>
          <input type="text" id="director" name="director">
        </div>

        <div>
          <label for="cast">Cast Member</label>
          <input type="text" id="cast" name="cast">
        </div>

        <div>
          <label for="genre">Genre</label>
          <input type="text" id="genre" name="genre">
        </div>

        <div>
          <label for="rating_min">Min Rating (0-10):</label>
          <input type="number" id="rating_min" name="rating_min" min="0" max="10" step="0.1">
        </div>

        <div>
          <label for="rating_max">Max Rating (0-10):</label>
          <input type="number" id="rating_max" name="rating_max" min="0" max="10" step="0.1">
        </div>

        <div>
          <button type="submit">SEARCH</button>
        </div>
      </fieldset>
    </form>
  </main>

  <footer>
    <p>Group 2 - CS 4347.007</p>
  </footer>
</body>
</html>
