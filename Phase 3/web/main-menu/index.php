<?php
include $_SERVER['DOCUMENT_ROOT'] . '/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Main Menu</title>
</head>
<body>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/logout_form.php'; ?>
	<a href="./view-site-services/view_site_services.php">View Site Services</a></br>
	<?php
	$conn = getConn();
	$SiteID = $_SESSION['siteid'];
	$sql = "SELECT COUNT(*) FROM FoodBank WHERE SiteID=$SiteID";
	$result = $conn->query($sql);
	$count = $result->fetch_row()[0];
	if ($count > 0){
	?>
		<a href="./add-delete-food-bank-item/index.php">Add/Delete Food Bank Item</a></br>
	<?php
	}
	?>
	<a href="./view-reports">View Reports</a></br>
	<br><br>
	<form action="http://localhost:8888/"><input type="submit" value="Home Page" /></form>
</body>
</html>
