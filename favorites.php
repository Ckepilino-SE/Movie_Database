<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="styles.css">
  <meta charset="UTF-8">
  <title>My Favorites - DataFlix</title>
</head>
<body>
  <header class="header">
    <a href="#default" class="logo">DataFlix</a>
    <div class="header-right">
      <a href="index.php">Home</a>
      <a href="search_movies.php">Search Movies</a>
      <a class="active" href="favorites.php">My Favorites</a>
      <a href="user_profile.php">My Profile</a>
      <a href="login.php">Login</a>
    </div>
  </header>

  <main>
    <table>
      <thead>
        <tr>
          <th>Title</th>
          <th>Release Year</th>
          <th>Genres</th>
          <th>Average Rating</th>
          <th>Details</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Example Favorite Movie</td>
          <td>2023</td>
          <td>Drama</td>
          <td>8.9</td>
          <td><a href="movie_details.html">View</a></td>
        </tr>
      </tbody>
    </table>
  </main>

  <footer>
    <p>Group 2 - CS 4347.007</p>
  </footer>
</body>
</html>
