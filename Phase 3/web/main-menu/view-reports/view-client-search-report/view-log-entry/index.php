<?php
include $_SERVER['DOCUMENT_ROOT'] . '/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>View Log Entry</title>
</head>
<body>

<?php
$clientid = $_GET['clientid'];
$conn = getConn();

$result = $conn->query("SELECT * FROM ServiceUsageLogEntry WHERE ClientID='$clientid'");
if($result->num_rows == 0){
  echo "<p>No Service Log Entry</p>";
} else {
  echo "<caption>Service Usage Log Entry</caption>";
  echo "<table border='1'>";
  echo "<tr>";
  echo "<th>TimeStamp</th>";
  echo "<th>ServiceType</th>";
  echo "<th>ExtraNotes</th>";
  echo "<tr>";
  while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['TimeStamp'] . "</td>";
    echo "<td>" . $row['ServiceType'] . "</td>";
    echo "<td>" . $row['ExtraNotes'] . "</td>";
    echo "</tr>";
  }
  echo "</table>";
}

echo "<br>";

$result = $conn->query("SELECT * FROM FieldModifiedLogEntry WHERE ClientID='$clientid'");
if($result->num_rows == 0){
  echo "<p>No Field Modified Log Entry</p>";
} else {
  echo "<caption>Field Modified Log Entry</caption>";
  echo "<table border='1'>";
  echo "<tr>";
  echo "<th>TimeStamp</th>";
  echo "<th>Description</th>";
  echo "<tr>";
  while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['TimeStamp'] . "</td>";
    echo "<td>" . $row['Description'] . "</td>";
    echo "</tr>";
  }
  echo "</table>";
}

echo "<br>";

$result = $conn->query("SELECT Site.ShortName, WaitlistEntry.OrderIndex FROM WaitlistEntry, Shelter, Site
  WHERE WaitlistEntry.ServiceID=Shelter.ServiceID
  AND Shelter.SiteID=Site.SiteID
  AND ClientID='$clientid'");
if($result->num_rows == 0){
  echo "<p>No Waitlist Entry</p>";
} else {
  echo "<caption>Wailist Entry</caption>";
  echo "<table border='1'>";
  echo "<tr>";
  echo "<th>Site</th>";
  echo "<th>OrderIndex</th>";
  echo "<tr>";
  while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['ShortName'] . "</td>";
    echo "<td>" . $row['OrderIndex'] . "</td>";
    echo "</tr>";
  }
  echo "</table>";
}
?>

</body>
</html>
