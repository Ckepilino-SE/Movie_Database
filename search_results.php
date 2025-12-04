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

  $results = [];

  try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    $sql = "SELECT Title, ReleaseDate, Genre, MPAARating, Runtime FROM MOVIE WHERE 1=1";
    $params = [];

    if (!empty($_POST['Title'])) {
      $sql .= " AND Title LIKE :Title";
      $params[':Title'] = '%' . $_POST['Title'] . '%';
    }

    if (!empty($_POST['ReleaseDate'])) {
        $sql .= " AND ReleaseDate = :ReleaseDate";
        $params[':ReleaseDate'] = $_POST['ReleaseDate'];
    }

    if (!empty($_POST['Genre'])) {
        $sql .= " AND Genre = :Genre";
        $params[':Genre'] = $_POST['Genre'];
    }

    if (!empty($_POST['MPAARating'])) {
        $sql .= " AND MPAARating = :MPAARating";
        $params[':MPAARating'] = $_POST['MPAARating'];
    }

    if (!empty($_POST['RuntimeMin']) && is_numeric($_POST['RuntimeMin'])) {
        $sql .= " AND Runtime >= :RuntimeMin";
        $params[':RuntimeMin'] = $_POST['RuntimeMin'];
    }
    
    if (!empty($_POST['RuntimeMax']) && is_numeric($_POST['RuntimeMax'])) {
        $sql .= " AND Runtime <= :RuntimeMax";
        $params[':RuntimeMax'] = $_POST['RuntimeMax'];
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $results = $stmt->fetchAll();

  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="styles.css">
  <meta charset="UTF-8">
  <title>Search Results - DataFlix</title>
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
    <h2>Movies Matching Your Search</h2>
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
          <?php foreach ($results as $row): ?>
            <tr>
                <td><a href="movie_details.php?title=<?php echo urlencode($row['Title']); ?>&release=<?php echo urlencode($row['ReleaseDate']); ?>"><?php echo htmlspecialchars($row['Title']); ?></a></td>
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
