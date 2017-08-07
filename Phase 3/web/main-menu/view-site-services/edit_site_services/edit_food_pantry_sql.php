<?php
include $_SERVER['DOCUMENT_ROOT'] . '/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
?>

<!DOCTYPE html>
<html>
<head>
<title> Edit Food Pantry </title>
</head>
<body>

<?php
$conn = getConn();

if (isset($_POST['save'])) {	
	$SiteID = $_SESSION['siteid'];
	$FacilityName = $_POST['FacilityName'];
	$HoursOfOperation = $_POST['HoursOfOperation'];	
        $sql = "UPDATE FoodPantry SET FacilityName='$FacilityName', HoursOfOperation='$HoursOfOperation' WHERE SiteID=$SiteID";
	
	if (!mysqli_query($conn, $sql)) {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
       
	$sql = "SELECT ServiceID FROM FoodPantry WHERE SiteID=$SiteID";
        $result = $conn->query($sql);
        $ServiceID = $result->fetch_row()[0];

	$sql = "DELETE FROM FoodPantryConditionForUse WHERE ServiceID=$ServiceID";
        if (!mysqli_query($conn, $sql)) {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

	$ConditionForUse = $_POST['ConditionForUse'];
	$ConditionForUseCount = count($ConditionForUse);
        $ServiceIDs = array_fill(0, $ConditionForUseCount, $ServiceID);
        for ($x = 0; $x < $ConditionForUseCount; $x++){
                $ConditionForUseRows[] = "({$ServiceIDs[$x]}, '{$ConditionForUse[$x]}')";
        }       
        $ConditionForUseArray = implode(", ", $ConditionForUseRows);
        $sql = "INSERT INTO FoodPantryConditionForUse (ServiceID, ConditionForUse) VALUES $ConditionForUseArray";
             
        if (!mysqli_query($conn, $sql)) {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }       
        else {
                echo "Site information is updated successfully";
        }

}

?>

<br><br>
<form action="http://localhost:8888/main-menu/view-site-services/view_site_services.php"><input type="submit" value="View Site Services" /></form>

</body>
</html>
