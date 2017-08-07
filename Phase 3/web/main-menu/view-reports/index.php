<?php
include $_SERVER['DOCUMENT_ROOT'] . '/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>View Reports</title>
</head>
<body>
  <a href="./view-client-search-report">View Client Search / Report</a></br>
  <a href="./view-item-search-report">View Item Search / Report</a></br>
<?php
$conn = getConn();
$username = $_SESSION['username'];

$result = $conn->query("SELECT COUNT(*) FROM Shelter
  INNER JOIN Site on Shelter.SiteID = Site.SiteID
  INNER JOIN User on Site.SiteID = User.SiteID and User.Username = '$username'");
$count = $result->num_rows;
if ($count > 0) {
?>
  <a href="./view-wait-list-report">View Wait-list Report</a></br>
<?php
}

$result = $conn->query("SELECT COUNT(*) FROM FoodBank
  INNER JOIN Site on FoodBank.SiteID = Site.SiteID
  INNER JOIN User on Site.SiteID = User.SiteID and User.Username = '$username'");
$count = $result->num_rows;
if ($count > 0) {
?>
  <a href="./view-outstanding-requests-report">View Outstanding Requests Report</a></br>
  <a href="./view-request-status-report">View Request Status Report</a></br>
<?php
}

?>
  <br>
  <br>
  <a href=/main-menu/index.php>Back</a>
  <br>
  <br>
</body>
</html>
