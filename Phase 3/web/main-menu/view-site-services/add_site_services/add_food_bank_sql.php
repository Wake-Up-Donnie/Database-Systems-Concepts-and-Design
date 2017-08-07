<?php
include $_SERVER['DOCUMENT_ROOT'] . '/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

$conn = getConn();

if (isset($_POST['submit'])) {
        $SiteID = $_SESSION['siteid'];
        $FacilityName = $_POST['FacilityName'];
        // echo $FacilityName;
	$sql = "INSERT INTO FoodBank (SiteID, FacilityName) VALUES ($SiteID, '$FacilityName')";

        if (!mysqli_query($conn, $sql)) {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
	else {
		echo "New Food Bank added to the Site";
	}
}
?>
<br><br>
<form action="http://localhost:8888/main-menu/view-site-services/view_site_services.php"><input type="submit" value="View Site Services" /></form>

