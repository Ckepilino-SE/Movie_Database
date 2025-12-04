<?php
session_start();
require_once __DIR__ . '/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = isset($_POST['email']) ? trim($_POST['email']) : '';
  $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';

  try {
    $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS, $DB_OPTIONS);
    $stmt = $pdo->prepare('SELECT Email, PhoneNumber, FirstName, LastName FROM USER WHERE Email = :email AND PhoneNumber = :phone');
    $stmt->execute([':email' => $email, ':phone' => $phone]);
    $user = $stmt->fetch();
    if ($user) {
      $_SESSION['user'] = [
        'email' => $user['Email'],
        'phone' => $user['PhoneNumber'],
        'name'  => trim(($user['FirstName'] ?? '') . ' ' . ($user['LastName'] ?? ''))
      ];
      header('Location: index.php');
      exit;
    } else {
      $error = 'No user found with that email/phone.';
    }
  } catch (Throwable $e) {
    $error = 'Error: ' . $e->getMessage();
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="styles.css">
  <meta charset="UTF-8">
  <title>Login - DataFlix</title>
</head>
<body>
  <header class="header">
    <a href="#default" class="logo">DataFlix</a>
    <div class="header-right">
      <a href="index.php">Home</a>
      <a href="search_movies.php">Search Movies</a>
      <a href="favorites.php">My Favorites</a>
      <a href="user_profile.php">My Profile</a>
      <a class="active" href="login.php">Login</a>
      <a href="register.php">Register</a>
    </div>
  </header>

  <main>
    <h2>Login</h2>
    <?php if (!empty($error)): ?>
      <p><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="post">
      <div>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required />
      </div>
      <div>
        <label for="phone">Phone Number</label>
        <input type="text" id="phone" name="phone" required />
      </div>
      <div>
        <button type="submit">Login</button>
      </div>
    </form>
  </main>

  <footer>
    <p>Group 2 - CS 4347.007</p>
  </footer>
</body>
</html>
