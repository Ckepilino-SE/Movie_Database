<?php
session_start();
require_once __DIR__ . '/config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $phone = trim($_POST['phone'] ?? '');
  $first = trim($_POST['first_name'] ?? '');
  $minit = trim($_POST['minit'] ?? '');
  $last = trim($_POST['last_name'] ?? '');
  $dob = trim($_POST['dob'] ?? '');
  $profile = trim($_POST['profile_picture'] ?? '');

  if (!$email || !$phone) {
    $error = 'Email and phone are required.';
  } else {
    try {
      $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS, $DB_OPTIONS);
      $stmt = $pdo->prepare('INSERT INTO USER (Email, PhoneNumber, FirstName, Minit, LastName, DateOfBirth, ProfilePicture) VALUES (:email, :phone, :first, :minit, :last, :dob, :profile)');
      $stmt->execute([
        ':email' => $email,
        ':phone' => $phone,
        ':first' => $first ?: null,
        ':minit' => $minit ?: null,
        ':last' => $last ?: null,
        ':dob' => $dob ?: null,
        ':profile' => $profile ?: null,
      ]);
      $success = 'Registration successful. You can now login.';
    } catch (Throwable $e) {
      $error = 'Error: ' . $e->getMessage();
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="styles.css">
  <meta charset="UTF-8">
  <title>Register - DataFlix</title>
</head>
<body>
  <header class="header">
    <a href="#default" class="logo">DataFlix</a>
    <div class="header-right">
      <a href="index.php">Home</a>
      <a href="search_movies.php">Search Movies</a>
      <a href="favorites.php">My Favorites</a>
      <a href="user_profile.php">My Profile</a>
      <a href="login.php">Login</a>
      <a class="active" href="register.php">Register</a>
    </div>
  </header>

  <main>
    <h2>Register</h2>
    <?php if (!empty($error)): ?>
      <p><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
      <p><?php echo htmlspecialchars($success); ?> <a href="login.php">Login</a></p>
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
        <label for="first_name">First Name</label>
        <input type="text" id="first_name" name="first_name" />
      </div>
      <div>
        <label for="minit">Middle Initial</label>
        <input type="text" id="minit" name="minit" maxlength="1" />
      </div>
      <div>
        <label for="last_name">Last Name</label>
        <input type="text" id="last_name" name="last_name" />
      </div>
      <div>
        <label for="dob">Date of Birth</label>
        <input type="date" id="dob" name="dob" />
      </div>
      <div>
        <label for="profile_picture">Profile Picture URL</label>
        <input type="url" id="profile_picture" name="profile_picture" />
      </div>
      <div>
        <button type="submit">Register</button>
      </div>
    </form>
  </main>

  <footer>
    <p>Group 2 - CS 4347.007</p>
  </footer>
</body>
</html>
