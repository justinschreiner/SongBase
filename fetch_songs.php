<?php
define('DB_HOST', 'mysql.eecs.ku.edu');
define('DB_NAME', 'jschreiner');
define('DB_CHARSET', 'utf8');
define('DB_USER', 'jschreiner');
define('DB_PASSWORD', 'pass123');

try {
  $pdo = new PDO(
    "mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET . ";dbname=" . DB_NAME,
    DB_USER, DB_PASSWORD, [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false ]
  );
} catch (Exception $ex) {
  die($ex->getMessage());
}

// (3) SEARCH
$stmt = $pdo->prepare("SELECT title FROM `SONGS` WHERE title LIKE ?");
$stmt->execute(["%" . $_POST['search'] . "%"]);
$results = $stmt->fetchAll();
if (isset($_POST['ajax'])) { echo json_encode($results); }
?>