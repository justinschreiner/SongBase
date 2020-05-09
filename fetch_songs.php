<!-- 
Returns songs matching criterea from songs.php song search form

@return { JSON } JSON object with results of the query. -->

<?php
// Initialize MySQL connection
define('DB_HOST', 'mysql.eecs.ku.edu');
define('DB_NAME', 'jschreiner');
define('DB_CHARSET', 'utf8');
define('DB_USER', 'jschreiner');
define('DB_PASSWORD', 'pass123');

try {
  $pdo = new PDO(
    "mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET . ";dbname=" . DB_NAME,
    DB_USER,
    DB_PASSWORD,
    [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => false
    ]
  );
} catch (Exception $ex) {
  die($ex->getMessage());
}

// Use if statements to find correct case of comparisons for tempo and duration.  Once found, create and execute query.
if ($_POST['tempoComparison'] == 'less') {
  if ($_POST['lengthComparison'] == 'less') {
    $stmt = $pdo->prepare("SELECT title, s_id FROM SONGS WHERE title LIKE ? AND tempo < ? AND duration < ?");
    $stmt->execute(["%" . $_POST['search'] . "%", $_POST['tempoValue'], $_POST['lengthValue']]);
  } else if ($_POST['lengthComparison'] == 'greater') {
    $stmt = $pdo->prepare("SELECT title, s_id FROM SONGS WHERE title LIKE ? AND tempo < ? AND duration > ?");
    $stmt->execute(["%" . $_POST['search'] . "%", $_POST['tempoValue'], $_POST['lengthValue']]);
  } else {
    $stmt = $pdo->prepare("SELECT title, s_id FROM SONGS WHERE title LIKE ? AND tempo < ?");
    $stmt->execute(["%" . $_POST['search'] . "%", $_POST['tempoValue']]);
  }
} else if ($_POST['tempoComparison'] == 'greater') {
  if ($_POST['lengthComparison'] == 'less') {
    $stmt = $pdo->prepare("SELECT title, s_id FROM SONGS WHERE title LIKE ? AND tempo > ? AND duration < ?");
    $stmt->execute(["%" . $_POST['search'] . "%", $_POST['tempoValue'], $_POST['lengthValue']]);
  } else if ($_POST['lengthComparison'] == 'greater') {
    $stmt = $pdo->prepare("SELECT title, s_id FROM SONGS WHERE title LIKE ? AND tempo > ? AND duration > ?");
    $stmt->execute(["%" . $_POST['search'] . "%", $_POST['tempoValue'], $_POST['lengthValue']]);
  } else {
    $stmt = $pdo->prepare("SELECT title, s_id FROM SONGS WHERE title LIKE ? AND tempo > ?");
    $stmt->execute(["%" . $_POST['search'] . "%", $_POST['tempoValue']]);
  }
} else {
  if ($_POST['lengthComparison'] == 'less') {
    $stmt = $pdo->prepare("SELECT title, s_id FROM SONGS WHERE title LIKE ? AND duration < ?");
    $stmt->execute(["%" . $_POST['search'] . "%", $_POST['lengthValue']]);
  } else if ($_POST['lengthComparison'] == 'greater') {
    $stmt = $pdo->prepare("SELECT title, s_id FROM SONGS WHERE title LIKE ? AND duration > ?");
    $stmt->execute(["%" . $_POST['search'] . "%", $_POST['lengthValue']]);
  } else {
    $stmt = $pdo->prepare("SELECT title, s_id FROM SONGS WHERE title LIKE ?");
    $stmt->execute(["%" . $_POST['search'] . "%"]);
  }
}

// Create and return JSON object with query results
$results = $stmt->fetchAll();
if (isset($_POST['ajax'])) {
  echo json_encode($results);
}
