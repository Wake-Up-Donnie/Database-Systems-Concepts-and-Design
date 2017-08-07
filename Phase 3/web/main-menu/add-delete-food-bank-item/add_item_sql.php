<?php
include $_SERVER['DOCUMENT_ROOT'] . '/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

$conn = getConn();
$SiteID = $_SESSION['siteid'];
$sql = "SELECT ServiceID FROM FoodBank WHERE SiteID = $SiteID";
$result = $conn->query($sql);
$ServiceID = $result->fetch_row()[0];

if (isset($_POST['submit'])) {
	$ItemName = $_POST['ItemName'];
	// echo $ItemName;
	$NumberOfUnits = $_POST['NumberOfUnits'];
	// echo $NumberOfUnits;
	$ExpirationDate = $_POST['ExpirationDate'];
	// echo $ExpirationDate;		
	$Subcategory = $_POST['Subcategory'];
	// echo $Subcategory;
	$Supply = array("PersonalHygiene", "Clothing", "Shelter", "Other"); 
	if (in_array($Subcategory, $Supply)) {
		$Category = "Supply";
	}
	else {
		$Category = "Food";
	}
	// echo $Category;
	$StorageType = $_POST['StorageType'];
	// echo $StorageType;	
}

$sql = "INSERT INTO Item (ServiceID, ItemName, NumberOfUnits, ExpirationDate, StorageType, Category, Subcategory)
	            VALUES ($ServiceID, '$ItemName', $NumberOfUnits, '$ExpirationDate', '$StorageType', '$Category', '$Subcategory')";

if (mysqli_query($conn, $sql)) {
	echo "New item inserted into the database";
}
else {	
	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}	
?>

<br><br>
<form action="http://localhost:8888/main-menu/add-food-bank-item/add_food_bank_item.php"><input type="submit" value="Add More Items" /></form>
<br>
<br>
<a href=/main-menu/add-delete-food-bank-item/add_food_bank_item.php>Back</a>
<br>
<br>