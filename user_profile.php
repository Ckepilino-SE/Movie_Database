<?php
session_start();
require_once __DIR__ . '/config.php';

$user = null;
$reviews = [];

try {
  if (isset($_SESSION['user'])) {
    $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS, $DB_OPTIONS);
    $email = $_SESSION['user']['email'] ?? '';
    $phone = $_SESSION['user']['phone'] ?? '';
    if ($email && $phone) {
      $stmt = $pdo->prepare('SELECT Email, PhoneNumber, FirstName, Minit, LastName, DateOfBirth, ProfilePicture FROM USER WHERE Email = :email AND PhoneNumber = :phone');
      $stmt->execute([':email' => $email, ':phone' => $phone]);
      $user = $stmt->fetch();

      // Recent ratings by this user (if any tables populated)
      $stmt = $pdo->prepare('SELECT m.Title AS MovieTitle, r.Rating, r.DatePosted FROM USER_REVIEW ur JOIN REVIEW r ON ur.DatePosted = r.DatePosted LEFT JOIN MOVIE m ON r.Author = m.Title WHERE ur.UserEmail = :email AND ur.UserPhoneNumber = :phone ORDER BY r.DatePosted DESC LIMIT 10');
      $stmt->execute([':email' => $email, ':phone' => $phone]);
      $reviews = $stmt->fetchAll();
    }
  }
} catch (Throwable $e) {
  // Non-fatal: show message inline below
  $errorMsg = 'Error: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="styles.css">
  <meta charset="UTF-8">
  <title>My Profile - DataFlix</title>
</head>
<body>
  <header class="header">
    <a href="#default" class="logo">DataFlix</a>
    <div class="header-right">
      <a href="index.php">Home</a>
      <a href="search_movies.php">Search Movies</a>
      <a href="favorites.php">My Favorites</a>
      <a class="active" href="user_profile.php">My Profile</a>
      <?php if (isset($_SESSION['user'])): ?>
        <a href="logout.php">Logout</a>
      <?php else: ?>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
      <?php endif; ?>
    </div>  
  </header>

  <main>
    <section>
      <h2>User Information</h2>
      <?php if (isset($errorMsg)) : ?>
        <p><?php echo htmlspecialchars($errorMsg); ?></p>
      <?php endif; ?>
      <?php if (!$user): ?>
        <p>Please <a href="login.php">login</a> to view your profile.</p>
      <?php else: ?>
        <p><strong>Name:</strong> <?php echo htmlspecialchars(trim(($user['FirstName'] ?? '') . ' ' . ($user['LastName'] ?? ''))); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['Email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['PhoneNumber']); ?></p>
        <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($user['DateOfBirth'] ?? ''); ?></p>
        <?php if (!empty($user['ProfilePicture'])): ?>
          <p><img src="<?php echo htmlspecialchars($user['ProfilePicture']); ?>" alt="Profile Picture" style="max-width:150px;" /></p>
        <?php endif; ?>
      <?php endif; ?>
    </section>

    <section>
      <h2>My Recent Ratings</h2>
      <?php if (!$user): ?>
        <p>Login to see your ratings.</p>
      <?php elseif (empty($reviews)): ?>
        <p>No ratings yet.</p>
      <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>Movie</th>
            <th>Rating</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($reviews as $r): ?>
            <tr>
              <td><?php echo htmlspecialchars($r['MovieTitle'] ?? ''); ?></td>
              <td><?php echo htmlspecialchars($r['Rating'] ?? ''); ?></td>
              <td><?php echo htmlspecialchars($r['DatePosted'] ?? ''); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php endif; ?>
    </section>
  </main>

  <footer>
    <p>Group 2 - CS 4347.007</p>
  </footer>
</body>
</html>
