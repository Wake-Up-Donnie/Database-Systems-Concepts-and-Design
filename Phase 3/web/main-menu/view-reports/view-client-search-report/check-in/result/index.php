<?php
include $_SERVER['DOCUMENT_ROOT'] . '/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Check-In Result</title>
</head>
<body>

<?php
$conn = getConn();
$siteid = $_SESSION['siteid'];
$siteshortname = $_SESSION['siteshortname'];
$serviceType = $_POST['serviceType'];
$clientid = $_POST['clientid'];
$extranotes = $_POST['extranotes'];

$query = "START TRANSACTION;";

if($serviceType == "MaleBunkAvailable" or
  $serviceType == "FemaleBunkAvailable" or
  $serviceType == "MixedBunkAvailable" or
  $serviceType == "FamilyRoomAvailable"){

  $shelterserviceid = $_POST['shelterserviceid'];
  $query = $query . "UPDATE Shelter
    SET $serviceType = $serviceType - 1
    WHERE ServiceID=$shelterserviceid;";
}

if($serviceType == "FamilyRoomWaitlist"){

  $shelterserviceid = $_POST['shelterserviceid'];
  $query = $query . "SET @MaxOrderIndex=(SELECT IFNULL(MAX(OrderIndex),0)
  FROM WaitlistEntry WHERE ServiceID=$shelterserviceid);";

  $query = $query . "INSERT INTO WaitlistEntry VALUES(
    $shelterserviceid,
    $clientid,
    @MaxOrderIndex+1
  );";
}

$query = $query . "INSERT INTO ServiceUsageLogEntry VALUES(
  $clientid,
  NULL,
  'Used $serviceType At $siteshortname',
  '$extranotes');";

$query = $query . "COMMIT;";
$result = $conn->multi_query($query);
if ($result){
  echo "<p>Successfully checked client into service $serviceType</p>";
}

?>
</body>
</html>
