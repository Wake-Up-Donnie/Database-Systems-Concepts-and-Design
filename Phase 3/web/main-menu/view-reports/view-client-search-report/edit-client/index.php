<?php
include $_SERVER['DOCUMENT_ROOT'] . '/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Client</title>
</head>
<body>

<form action="./result/" method="post">
<?php
$is_enroll_or_edit = true;
$clientid = $_GET['clientid'];

$conn = getConn();
$result = $conn->query("SELECT * FROM Client WHERE ClientID='$clientid'");
if($row = $result->fetch_assoc()){
  $firstname = $row['FirstName'];
  $lastname = $row['LastName'];
  $idnumber = $row['IDNumber'];
  $iddescription = $row['IDDescription'];
  $ishead = $row['IsHeadOfHousehold'];
  $phone = $row['Phone'];
}

include '../user_form.php';
?>
</form><br>

</body>
</html>
