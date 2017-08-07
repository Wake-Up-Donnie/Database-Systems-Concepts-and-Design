<?php
include $_SERVER['DOCUMENT_ROOT'] . '/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Client Result</title>
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

$clientid = $_POST['clientid'];
$query = "SELECT * FROM Client WHERE ClientID='$clientid'";
$oldResult = $conn->query($query);
if ($row = $oldResult->fetch_assoc()) {
  $query = "START TRANSACTION; ";
  $message = json_encode($row);
  $message = preg_replace('/"|\{|\}/','', $message);
  $message = preg_replace('/,/',', ', $message);

  $query = $query . "INSERT INTO FieldModifiedLogEntry VALUES(
    $clientid,
    NULL,
    '$message'); ";

  $query = $query . "UPDATE Client SET
    FirstName='$firstname',
    LastName='$lastname',
    IDNumber='$idnumber',
    IDDescription='$iddescription',
    IsHeadOfHousehold=$ishead,
    Phone='$phone'
    WHERE ClientID='$clientid';";

  $query = $query . "COMMIT;";

  $result = $conn->multi_query($query);

  if ($result) {
    echo "<p>Successfully edited client: $firstname $lastname";
  } else {
    echo "<p>Failed to edit client: $firstname $lastname";
  }
} else {
    echo "<p>No client exist</p>";
}
?>
</body>
</html>
