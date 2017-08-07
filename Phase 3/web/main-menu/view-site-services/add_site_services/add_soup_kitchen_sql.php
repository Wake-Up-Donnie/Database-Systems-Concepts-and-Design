<?php
include $_SERVER['DOCUMENT_ROOT'] . '/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

$conn = getConn();

if (isset($_POST['submit'])) {
        $SiteID = $_SESSION['siteid'];
        $FacilityName = $_POST['FacilityName'];
        $HoursOfOperation = $_POST['HoursOfOperation'];
        $SeatsCapacity = $_POST['SeatsCapacity'];
        $SeatsAvailable = $_POST['SeatsAvailable'];
	$ConditionForUse = $_POST['ConditionForUse'];	
	
$sql = "INSERT INTO SoupKitchen (SiteID, FacilityName, HoursOfOperation, SeatsCapacity, SeatsAvailable) VALUES ($SiteID, '$FacilityName', '$HoursOfOperation', $SeatsCapacity, $SeatsAvailable)";

if (!mysqli_query($conn, $sql)) {
	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

$sql = "SELECT ServiceID FROM SoupKitchen WHERE SiteID=$SiteID";
$result = $conn->query($sql);
$ServiceID = $result->fetch_row()[0];

$ConditionForUseCount = count($ConditionForUse);
$ServiceIDs = array_fill(0, $ConditionForUseCount, $ServiceID);

for ($x = 0; $x < $ConditionForUseCount; $x++){
	$ConditionForUseRows[] = "({$ServiceIDs[$x]}, '{$ConditionForUse[$x]}')";
}
$ConditionForUseArray = implode(", ", $ConditionForUseRows);
$sql = "INSERT INTO SoupKitchenConditionForUse (ServiceID, ConditionForUse) VALUES $ConditionForUseArray";

if (!mysqli_query($conn, $sql)) {
	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
else {
	echo "New SoupKitchen added to the Site";	
}

}
?>
<br><br>
<form action="http://localhost:8888/main-menu/view-site-services/view_site_services.php"><input type="submit" value="View Site Services" /></form>
