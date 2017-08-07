<?php
include $_SERVER['DOCUMENT_ROOT'] . '/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
?>

<!DOCTYPE html>
<html>
<head>
<title> Edit Food Bank </title>
</head>
<body>

<?php
$conn = getConn();

if (isset($_POST['save'])) {	
	$SiteID = $_SESSION['siteid'];
	$FacilityName = $_POST['FacilityName'];
	
        $sql = "UPDATE FoodBank SET FacilityName='$FacilityName' WHERE SiteID=$SiteID";
	
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
