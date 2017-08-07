<?php
include $_SERVER['DOCUMENT_ROOT'] . '/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Enroll Client Result</title>
</head>
<body>

<?php
$conn = getConn();
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$idnumber = $_POST['idnumber'];
$iddescription = $_POST['iddescription'];
$ishead = $_POST['ishead'];
$phone = $_POST['phone'];

$result = $conn->query("INSERT INTO Client
  VALUES (NULL, '$firstname', '$lastname', '$idnumber', '$iddescription', $ishead, '$phone')");

if ($result) {
  echo "<p>Successfully enrolled client: $firstname $lastname";
} else {
  echo "<p>Failed to enroll client: $firstname $lastname";
}

?>
<br>
<br>
<a href=/main-menu/view-reports/view-client-search-report/enroll-client/index.php>Back</a>
<br>
<br>
</body>
</html>
