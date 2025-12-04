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
      <a href="register.php">Register</a>
    </div>  
  </header>

  <main>
    <form action="search_results.php", method="POST">
        <div>
          <label for="Title">Title</label>
          <input type="text" id="Title" name="Title">
        </div>

        <div>
          <label for="ReleaseDate">Release Date</label>
          <input type="text" id="ReleaseDate" name="ReleaseDate">
        </div>

        <div>
          <label for="Genre">Genre</label>
          <input type="text" id="Genre" name="Genre">
        </div>

        <div>
          <label for="MPAARating">MPAA Rating</label>
          <input type="text" id="MPAARating" name="MPAARating">
        </div>

        <div>
          <label for="RuntimeMin">Minimum Runtime</label>
          <input type="number" id="RuntimeMin" name="RuntimeMin">
        </div>

        <div>
          <label for="RuntimeMax">Maximum Runtime</label>
          <input type="number" id="RuntimeMax" name="RuntimeMax">
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
