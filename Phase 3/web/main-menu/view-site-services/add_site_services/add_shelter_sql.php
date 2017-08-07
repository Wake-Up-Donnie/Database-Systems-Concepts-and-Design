<?php
include $_SERVER['DOCUMENT_ROOT'] . '/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

$conn = getConn();

if (isset($_POST['submit'])) {
        $SiteID = $_SESSION['siteid'];
        $FacilityName = $_POST['FacilityName'];
        // echo $FacilityName;
        $HoursOfOperation = $_POST['HoursOfOperation'];
        // echo $HoursOfOperation;
	$MaleBunkAvailable = $_POST['MaleBunkAvailable'];
	$FemaleBunkAvailable = $_POST['FemaleBunkAvailable'];
	$MixedBunkAvailable = $_POST['MixedBunkAvailable'];
	$FamilyRoomAvailable = $_POST['FamilyRoomAvailable'];
        $ConditionForUse = $_POST['ConditionForUse'];
        // echo is_array($ConditionForUse);
        // echo "Hello";
        // foreach ($ConditionForUse as $value){
        //        echo "{$value}<br>";
        //}
        // echo count($ConditionForUse);

        $sql = "INSERT INTO Shelter (SiteID, FacilityName, HoursOfOperation, MaleBunkAvailable, FemaleBunkAvailable, MixedBunkAvailable, FamilyRoomAvailable) VALUES ($SiteID, '$FacilityName', '$HoursOfOperation', $MaleBunkAvailable, $FemaleBunkAvailable, $MixedBunkAvailable, $FamilyRoomAvailable)";

        if (!mysqli_query($conn, $sql)) {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        $sql = "SELECT ServiceID FROM Shelter WHERE SiteID=$SiteID";
        $result = $conn->query($sql);
        $ServiceID = $result->fetch_row()[0];

        $ConditionForUseCount = count($ConditionForUse);
        $ServiceIDs = array_fill(0, $ConditionForUseCount, $ServiceID);
        for ($x = 0; $x < $ConditionForUseCount; $x++){
                $ConditionForUseRows[] = "({$ServiceIDs[$x]}, '{$ConditionForUse[$x]}')";
        }
        $ConditionForUseArray = implode(", ", $ConditionForUseRows);
	$sql = "INSERT INTO ShelterConditionForUse (ServiceID, ConditionForUse) VALUES $ConditionForUseArray";

        if (!mysqli_query($conn, $sql)) {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        else {
                echo "New Shelter added to the Site";
        }
}
?>
<br><br>
<form action="http://localhost:8888/main-menu/view-site-services/view_site_services.php"><input type="submit" value="View Site Services" /></form>


