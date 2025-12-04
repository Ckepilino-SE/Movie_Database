<?php
session_start();
require_once __DIR__ . '/config.php';

$favorites = [];
$message = '';

try {
  $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS, $DB_OPTIONS);

  // Handle add-to-favorites from details page
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
    $email = $_SESSION['user']['email'] ?? '';
    $phone = $_SESSION['user']['phone'] ?? '';
    $mtitle = $_POST['movie_title'] ?? '';
    $mrelease = $_POST['movie_release'] ?? '';
    if ($email && $phone && $mtitle && $mrelease) {
      $stmt = $pdo->prepare('INSERT IGNORE INTO FAVORITES (UserEmail, UserPhoneNumber, MovieTitle, MovieReleaseDate) VALUES (:email, :phone, :title, :release)');
      $stmt->execute([':email' => $email, ':phone' => $phone, ':title' => $mtitle, ':release' => $mrelease]);
      $message = 'Added to favorites.';
    }
  }

  // Load current user's favorites
  if (isset($_SESSION['user'])) {
    $email = $_SESSION['user']['email'] ?? '';
    $phone = $_SESSION['user']['phone'] ?? '';
    if ($email && $phone) {
      $stmt = $pdo->prepare('SELECT f.MovieTitle AS Title, f.MovieReleaseDate AS ReleaseDate, m.Genre, m.MPAARating, m.Runtime FROM FAVORITES f JOIN MOVIE m ON f.MovieTitle = m.Title AND f.MovieReleaseDate = m.ReleaseDate WHERE f.UserEmail = :email AND f.UserPhoneNumber = :phone');
      $stmt->execute([':email' => $email, ':phone' => $phone]);
      $favorites = $stmt->fetchAll();
    }
  }
} catch (Throwable $e) {
  $message = 'Error: ' . $e->getMessage();
}
?>
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
      <?php if (isset($_SESSION['user'])): ?>
        <a href="logout.php">Logout</a>
      <?php else: ?>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
      <?php endif; ?>
    </div>
  </header>

  <main>
    <?php if (!empty($message)): ?>
      <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <?php if (!isset($_SESSION['user'])): ?>
      <p>Please <a href="login.php">login</a> to view your favorites.</p>
    <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>Title</th>
          <th>Release Date</th>
          <th>Genre</th>
          <th>MPAA Rating</th>
          <th>Details</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($favorites as $row): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['Title']); ?></td>
            <td><?php echo htmlspecialchars($row['ReleaseDate']); ?></td>
            <td><?php echo htmlspecialchars($row['Genre']); ?></td>
            <td><?php echo htmlspecialchars($row['MPAARating']); ?></td>
            <td><a href="movie_details.php?title=<?php echo urlencode($row['Title']); ?>&release=<?php echo urlencode($row['ReleaseDate']); ?>">View</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php endif; ?>
  </main>

  <footer>
    <p>Group 2 - CS 4347.007</p>
  </footer>
</body>
</html>
