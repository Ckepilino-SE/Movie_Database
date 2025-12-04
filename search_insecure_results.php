<?php
require_once __DIR__ . '/config.php';

$rawTitle = $_POST['Title'] ?? '';
$rawRelease = $_POST['ReleaseDate'] ?? '';

// INSECURE: build SQL with direct concatenation (subject to injection)
$sql = "SELECT Title, ReleaseDate, Genre, MPAARating, Runtime FROM MOVIE WHERE 1=1";
if ($rawTitle !== '') {
  // Allow partial matching but unsafe concatenation
  $sql .= " AND Title LIKE '%" . $rawTitle . "%'";
}
if ($rawRelease !== '') {
  $sql .= " AND ReleaseDate = '" . $rawRelease . "'";
}

$rows = [];
$error = '';
try {
  $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS, $DB_OPTIONS);
  $stmt = $pdo->query($sql);
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
  <title>Insecure Search Results - DataFlix</title>
</head>
<body>
  <header class="header">
    <a href="#default" class="logo">DataFlix</a>
    <div class="header-right">
      <a href="index.php">Home</a>
      <a href="search_insecure.php">Injection Demo</a>
      <a class="active" href="search_insecure_results.php">Results</a>
      <a href="search_movies.php">Search Movies</a>
      <a href="favorites.php">My Favorites</a>
      <a href="user_profile.php">My Profile</a>
      <a href="login.php">Login</a>
      <a href="register.php">Register</a>
    </div>
  </header>

  <main>
    <h2>Insecure Search Results</h2>
    <?php if ($error): ?>
      <p><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
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

    <h3>Secure Version (Prepared Statements)</h3>
    <p>Use the secure search that prevents SQL injection:</p>
    <form action="search_secure_results.php" method="POST">
      <div>
        <label for="Title2">Title</label>
        <input type="text" id="Title2" name="Title" placeholder="e.g., Inception">
      </div>
      <div>
        <label for="ReleaseDate2">Release Date (optional)</label>
        <input type="text" id="ReleaseDate2" name="ReleaseDate" placeholder="YYYY-MM-DD">
      </div>
      <div>
        <button type="submit">Run Secure Search</button>
      </div>
    </form>
  </main>

  <footer>
    <p>Group 2 - CS 4347.007</p>
  </footer>
</body>
</html>
