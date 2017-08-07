<?php
session_start();
$SiteID = $_SESSION['siteid'];
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
?>

<!DOCTYPE html>
<html>
<head>
<title> Add Site Services </title>
</head>
<body>

<?php
$conn = getConn();
$result = $conn->query("SELECT COUNT(*) FROM SoupKitchen WHERE SiteID=$SiteID");
$count_1 = $result->fetch_row()[0];
if ($count_1 == 0){
?>
	<a href="./add_site_services/add_soup_kitchen.php"> Add Soup Kitchen </a><br>
<?php
}
$result = $conn->query("SELECT COUNT(*) FROM FoodPantry WHERE SiteID=$SiteID");
$count_2 = $result->fetch_row()[0];
if ($count_2 == 0){
?>
	<a href="./add_site_services/add_food_pantry.php"> Add Food Pantry </a><br>
<?php
}
$result = $conn->query("SELECT COUNT(*) FROM Shelter WHERE SiteID=$SiteID");
$count_3 = $result->fetch_row()[0];
if ($count_3 == 0){
?>
	<a href="./add_site_services/add_shelter.php"> Add Shelter </a><br>
<?php
}
$result = $conn->query("SELECT COUNT(*) FROM FoodBank WHERE SiteID=$SiteID");
$count_4 = $result->fetch_row()[0];
if ($count_4 == 0){
?>
	<a href="./add_site_services/add_food_bank.php"> Add Food Bank </a><br>
<?php
}

if ($count_1 > 0 && $count_2 > 0 && $count_3 > 0 && $count_4 > 0){
	echo "Currently, the site has all types of services. No more Services can be added!";
}
?>

<br><br>
<form action="http://localhost:8888/main-menu/view-site-services/view_site_services.php"><input type="submit" value="back" /></form>

</body>
</html>
