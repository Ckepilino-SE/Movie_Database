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
    <?php
      echo "<table>";
      echo "<thead>
              <tr>
                <th>Title</th>
                <th>Release Date</th>
                <th>Genre</th>
                <th>Average Rating</th>
                <th>Runtime</th>
              </tr>
            </thead>";
      echo "<tbody>";

      class TableRows extends RecursiveIteratorIterator {
        function __construct($it) {
          parent::__construct($it, self::LEAVES_ONLY);
        }

        function current() : mixed {
          return "" . parent::current(). "</td>";
        }

        function beginChildren() : void  {
          echo "<tr>";
        }

        function endChildren() : void   {
          echo "</tr>" . "\n";
        }
      }

      $servername = "localhost,3306";
      $username = "root";
      $password = "password";
      $dbname = "movie_db";

      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT Title, ReleaseDate, Genre, MPAARating, Runtime FROM Movie");
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
          echo $v;
        }
      } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      $conn = null;

      echo "</tbody>";
      echo "</table>";
    ?>
  </main>

  <footer>
    <p>Group 2 - CS 4347.007</p>
  </footer>
</body>
</html>
