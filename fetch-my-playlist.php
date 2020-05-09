<!-- 
Finds data from all playlists owned by the current user

@return { JSON } JSON object with results of the query. -->

<?php
// Initialize MySQL connection
session_start();

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
$id = $_POST['uid'];

// Create and execute query
$stmt = $pdo->prepare("SELECT * FROM PLAYLISTS WHERE PLAYLISTS.u_id = $id");
$stmt->execute();
$results = $stmt->fetchAll();
if (isset($_POST['ajax'])) {
  echo json_encode($results);
}
?>