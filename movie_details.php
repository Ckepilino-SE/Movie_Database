<?php
  $host = '127.0.0.1';
  $db   = 'movie_db';
  $user = 'root';
  $pass = '';
  $charset = 'utf8mb4';

  $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
  $options = [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES   => false,
  ];

  $movie = null;
  $directors = [];
  $writers = [];
  $cast = [];
  $ratings = [];

  $titleParam = isset($_GET['title']) ? $_GET['title'] : '';
  $releaseParam = isset($_GET['release']) ? $_GET['release'] : '';

  try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    if (!empty($titleParam) && !empty($releaseParam)) {
      // Movie core details (composite PK: Title + ReleaseDate)
      $stmt = $pdo->prepare("SELECT Title, ReleaseDate, Genre, Runtime, MPAARating FROM MOVIE WHERE Title = :title AND ReleaseDate = :release");
      $stmt->execute([':title' => $titleParam, ':release' => $releaseParam]);
      $movie = $stmt->fetch();

      // Directors
      $stmt = $pdo->prepare("SELECT CONCAT(p.FirstName, ' ', p.LastName) AS FullName FROM DIRECTS d JOIN PERSON p ON d.FirstName = p.FirstName AND d.LastName = p.LastName AND d.DateOfBirth = p.DateOfBirth WHERE d.MovieTitle = :title AND d.MovieReleaseDate = :release");
      $stmt->execute([':title' => $titleParam, ':release' => $releaseParam]);
      $directors = $stmt->fetchAll(PDO::FETCH_COLUMN);

      // Writers
      $stmt = $pdo->prepare("SELECT CONCAT(p.FirstName, ' ', p.LastName) AS FullName FROM WRITES w JOIN PERSON p ON w.FirstName = p.FirstName AND w.LastName = p.LastName AND w.DateOfBirth = p.DateOfBirth WHERE w.MovieTitle = :title AND w.MovieReleaseDate = :release");
      $stmt->execute([':title' => $titleParam, ':release' => $releaseParam]);
      $writers = $stmt->fetchAll(PDO::FETCH_COLUMN);

      // Cast
      $stmt = $pdo->prepare("SELECT CONCAT(p.FirstName, ' ', p.LastName) AS FullName FROM STARS_IN s JOIN PERSON p ON s.FirstName = p.FirstName AND s.LastName = p.LastName AND s.DateOfBirth = p.DateOfBirth WHERE s.MovieTitle = :title AND s.MovieReleaseDate = :release");
      $stmt->execute([':title' => $titleParam, ':release' => $releaseParam]);
      $cast = $stmt->fetchAll(PDO::FETCH_COLUMN);

      // Ratings placeholder: if you have ratings table(s), query them here
      // Example: SELECT sources and values
      // $stmt = $pdo->prepare("SELECT Source, Score FROM RATINGS WHERE MovieID = :id");
      // $stmt->execute([':id' => $id]);
      // $ratings = $stmt->fetchAll();
    }
  } catch(PDOException $e) {
    $errorMsg = "Error: " . $e->getMessage();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="styles.css">
  <meta charset="UTF-8">
  <title>Movie Details - DataFlix</title>
  <style>
    main section { margin-bottom: 24px; }
    .meta p { margin: 4px 0; }
    .pill { display:inline-block; background:#eee; padding:2px 8px; border-radius:12px; margin-right:6px; }
  </style>
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
    <?php if (isset($errorMsg)) : ?>
      <p><?php echo htmlspecialchars($errorMsg); ?></p>
    <?php elseif (!$movie) : ?>
      <h2>Movie not found</h2>
      <p>Try returning to <a href="search_movies.php">Search Movies</a> and selecting a different title.</p>
    <?php else: ?>
    <section>
      <h2><?php echo htmlspecialchars($movie['Title']); ?></h2>
      <div class="meta">
        <p><strong>Release Date:</strong> <?php echo htmlspecialchars($movie['ReleaseDate']); ?></p>
        <p><strong>Genre:</strong> <?php echo htmlspecialchars($movie['Genre']); ?></p>
        <p><strong>Runtime:</strong> <?php echo htmlspecialchars($movie['Runtime']); ?> minutes</p>
        <p><strong>MPAA Rating:</strong> <?php echo htmlspecialchars($movie['MPAARating']); ?></p>
      </div>
    </section>

    <section>
      <h3>Cast & Crew</h3>
      <p><strong>Director(s):</strong> <?php echo $directors ? htmlspecialchars(implode(', ', $directors)) : '—'; ?></p>
      <p><strong>Writer(s):</strong> <?php echo $writers ? htmlspecialchars(implode(', ', $writers)) : '—'; ?></p>
      <p><strong>Cast:</strong> <?php echo $cast ? htmlspecialchars(implode(', ', $cast)) : '—'; ?></p>
    </section>

    <section>
      <h3>Ratings</h3>
      <?php if (!empty($ratings)) : ?>
        <ul>
          <?php foreach ($ratings as $r): ?>
            <li><strong><?php echo htmlspecialchars($r['Source']); ?>:</strong> <?php echo htmlspecialchars($r['Score']); ?></li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <p>No ratings data available.</p>
      <?php endif; ?>
    </section>

    <section>
      <h3>Actions</h3>
      <form method="post" action="favorites.php">
        <input type="hidden" name="movie_title" value="<?php echo htmlspecialchars($movie['Title']); ?>" />
        <input type="hidden" name="movie_release" value="<?php echo htmlspecialchars($movie['ReleaseDate']); ?>" />
        <button type="submit">Add to Favorites</button>
      </form>

      <form method="get" action="rate_movie.php">
        <input type="hidden" name="movie_title" value="<?php echo htmlspecialchars($movie['Title']); ?>" />
        <input type="hidden" name="movie_release" value="<?php echo htmlspecialchars($movie['ReleaseDate']); ?>" />
        <button type="submit">Rate / Review This Movie</button>
      </form>
    </section>
    <?php endif; ?>
  </main>

  <footer>
    <p>Group 2 - CS 4347.007</p>
  </footer>
</body>
</html>
