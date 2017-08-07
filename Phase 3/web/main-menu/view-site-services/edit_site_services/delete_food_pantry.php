<?php
include $_SERVER['DOCUMENT_ROOT'] . '/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
?>

<!DOCTYPE html>
<html>
<head>
<title> Delete Food Pantry </title>
</head>
<body>

<?php
$conn = getConn();

if (isset($_POST['delete'])) {
	$SiteID = $_SESSION['siteid'];
	
	$sql = "SELECT COUNT(*) FROM SoupKitchen WHERE SiteID=$SiteID";
        $result = $conn->query($sql);
        $count_sk = $result->fetch_row()[0];

        $sql = "SELECT COUNT(*) FROM FoodPantry WHERE SiteID=$SiteID";
        $result = $conn->query($sql);
        $count_fp = $result->fetch_row()[0];

        $sql = "SELECT COUNT(*) FROM Shelter WHERE SiteID=$SiteID";
        $result = $conn->query($sql);
        $count_sh = $result->fetch_row()[0];

        $sql = "SELECT COUNT(*) FROM FoodBank WHERE SiteID=$SiteID";
        $result = $conn->query($sql);
        $count_fb = $result->fetch_row()[0];

        $count = $count_sk + $count_fp + $count_sh + $count_fb;
	
        if ($count == 1) { 
                echo "This Service is the last Service. You can not delete it!";
        }
        else {	
        	$sql = "SELECT ServiceID FROM FoodPantry WHERE SiteID=$SiteID";
        	$result = $conn->query($sql);
        	$ServiceID = $result->fetch_row()[0];
	
		$sql = "DELETE FROM FoodPantry WHERE SiteID=$SiteID";
		if (!mysqli_query($conn, $sql)) {
                	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        	}
		else {
			echo "The service is deleted successfully!";
		}
	}
}  

?>

<br><br>
<form action="http://localhost:8888/main-menu/view-site-services/view_site_services.php"><input type="submit" value="View Site Services" /></form>

</body>
</html>
