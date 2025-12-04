<?php
require_once __DIR__ . '/config.php';

$title = $_POST['Title'] ?? '';
$release = $_POST['ReleaseDate'] ?? '';

$sql = "SELECT Title, ReleaseDate, Genre, MPAARating, Runtime FROM MOVIE WHERE 1=1";
$params = [];

if ($title !== '') {
  $sql .= " AND Title LIKE :title";
  $params[':title'] = '%' . $title . '%';
}
if ($release !== '') {
  $sql .= " AND ReleaseDate = :release";
  $params[':release'] = $release;
}

$rows = [];
$error = '';
try {
  $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS, $DB_OPTIONS);
  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);
  $rows = $stmt->fetchAll();
} catch (Throwable $e) {
  $error = 'Error: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="styles.css">
  <meta charset="UTF-8">
  <title>Secure Search Results - DataFlix</title>
</head>
<body>
  <header class="header">
    <a href="#default" class="logo">DataFlix</a>
    <div class="header-right">
      <a href="index.php">Home</a>
      <a href="search_insecure.php">Injection Demo</a>
      <a class="active" href="search_secure_results.php">Results</a>
      <a href="search_movies.php">Search Movies</a>
      <a href="favorites.php">My Favorites</a>
      <a href="user_profile.php">My Profile</a>
      <a href="login.php">Login</a>
      <a href="register.php">Register</a>
    </div>
  </header>

  <main>
    <h2>Secure Search Results</h2>
    <?php if ($error): ?>
      <p><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <p><strong>Prepared SQL:</strong> <code><?php echo htmlspecialchars($sql); ?></code></p>
    <p><strong>Params:</strong> <code><?php echo htmlspecialchars(json_encode($params)); ?></code></p>

    <table>
      <thead>
        <tr>
          <th>Title</th>
          <th>Release Date</th>
          <th>Genre</th>
          <th>MPAA Rating</th>
          <th>Runtime</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $row): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['Title']); ?></td>
            <td><?php echo htmlspecialchars($row['ReleaseDate']); ?></td>
            <td><?php echo htmlspecialchars($row['Genre']); ?></td>
            <td><?php echo htmlspecialchars($row['MPAARating']); ?></td>
            <td><?php echo htmlspecialchars($row['Runtime']); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </main>

  <footer>
    <p>Group 2 - CS 4347.007</p>
  </footer>
</body>
</html>
