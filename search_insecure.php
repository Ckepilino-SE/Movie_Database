<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="styles.css">
  <meta charset="UTF-8">
  <title>Insecure Search Demo - DataFlix</title>
</head>
<body>
  <header class="header">
    <a href="#default" class="logo">DataFlix</a>
    <div class="header-right">
      <a href="index.php">Home</a>
      <a class="active" href="search_insecure.php">Injection Demo</a>
      <a href="search_movies.php">Search Movies</a>
      <a href="favorites.php">My Favorites</a>
      <a href="user_profile.php">My Profile</a>
      <a href="login.php">Login</a>
      <a href="register.php">Register</a>
    </div>
  </header>

  <main>
    <h2>Insecure Search (for demonstration)</h2>
    <p>Try entering a title or an injected string like: <code>' OR '1'='1</code></p>
    <form action="search_insecure_results.php" method="POST">
      <div>
        <label for="Title">Title</label>
        <input type="text" id="Title" name="Title" placeholder="e.g., Inception or ' OR '1'='1">
      </div>
      <div>
        <label for="ReleaseDate">Release Date (optional)</label>
        <input type="text" id="ReleaseDate" name="ReleaseDate" placeholder="YYYY-MM-DD">
      </div>
      <div>
        <button type="submit">Run Insecure Search</button>
      </div>
    </form>
  </main>

  <footer>
    <p>Group 2 - CS 4347.007</p>
  </footer>
</body>
</html>
