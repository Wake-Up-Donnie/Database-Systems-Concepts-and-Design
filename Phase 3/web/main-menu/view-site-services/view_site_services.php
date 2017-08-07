<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title> View Site Services </title>
</head>
<body>

<h1> Site Services </h1>
<a href="./add_site_services.php">Add Site Services</a></br>

<?php

$user = 'root';
$password = 'root';
$db = 'acacs';
$host = '127.0.0.1';
$port = 8889;
$conn = mysqli_connect($host, $user, $password, $db, $port);

if (!$conn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$SiteID = $_SESSION['siteid'];

// SoupKitchen
$sql = "SELECT FacilityName, HoursOfOperation, SeatsCapacity, SeatsAvailable, Phone, StreetAddress
FROM SoupKitchen
JOIN 
Site on SoupKitchen.SiteID = Site.SiteID
WHERE Site.SiteID=$SiteID";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
	?><h2><a href="./edit_site_services/edit_soup_kitchen.php">Soup Kitchen</a></h2><?php
        echo "<table width=90% border=1>
        <tr>
                <th>FacilityName</th>
                <th>HoursOfOperation</th>
                <th>SeatsCapacity</th>
                <th>SeatsAvailable</th>
		<th>Phone</th>
		<th>StreetAddress</th> 
        </tr>";

        // output data of each row
        while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['FacilityName'] . "</td>";
                echo "<td>" . $row['HoursOfOperation'] . "</td>";
                echo "<td>" . $row['SeatsCapacity'] . "</td>";
                echo "<td>" . $row['SeatsAvailable'] . "</td>";
		echo "<td>" . $row['Phone'] . "</td>";
		echo "<td>" . $row['StreetAddress'] . "</td>";
		echo "</tr>";
        }

	echo "</table>";

	$sql = "SELECT ConditionForUse
	FROM SoupKitchenConditionForUse
	WHERE ServiceID=(SELECT ServiceID FROM SoupKitchen WHERE SiteID=$SiteID)";

	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo "<br>";
		echo "Condition For Use: ";
		while ($row = $result->fetch_assoc()) {
			echo $row['ConditionForUse'] . "   ";
		}
	}
	echo "<br><br>";
}


// Food Pantry
$sql = "SELECT FacilityName, HoursOfOperation, Phone, StreetAddress
FROM FoodPantry
JOIN
Site on FoodPantry.SiteID = Site.SiteID
WHERE Site.SiteID=$SiteID";


$result = $conn->query($sql);

if ($result->num_rows > 0) {
        ?><h2><a href="./edit_site_services/edit_food_pantry.php">Food Pantry</a></h2><?php
	echo "<table width=90% border=1>
        <tr>
                <th>FacilityName</th>
                <th>HoursOfOperation</th>
                <th>Phone</th>
                <th>StreetAddress</th>
        </tr>";

        // output data of each row
        while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['FacilityName'] . "</td>";
                echo "<td>" . $row['HoursOfOperation'] . "</td>";
                echo "<td>" . $row['Phone'] . "</td>";
                echo "<td>" . $row['StreetAddress'] . "</td>";
                echo "</tr>";
        }

	echo "</table>";

	$sql = "SELECT ConditionForUse
	FROM FoodPantryConditionForUse
	WHERE ServiceID=(SELECT ServiceID FROM FoodPantry WHERE SiteID=$SiteID)";

	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo "<br>";
		echo "Condition For Use: ";
		while ($row = $result->fetch_assoc()) {
			echo $row['ConditionForUse'] . "   ";
		}
	}
	echo "<br><br>";
}


// Shelter
$sql = "SELECT FacilityName, HoursOfOperation, MaleBunkAvailable, FemaleBunkAvailable, MixedBunkAvailable, FamilyRoomAvailable, Phone, StreetAddress
FROM Shelter
JOIN
Site on Shelter.SiteID = Site.SiteID
WHERE Site.SiteID=$SiteID";


$result = $conn->query($sql);

if ($result->num_rows > 0) {
	?><h2><a href="./edit_site_services/edit_shelter.php">Shelter</a></h2><?php
        echo "<table width=90% border=1>
        <tr>
                <th>FacilityName</th>
                <th>HoursOfOperation</th>
		<th>MaleBunkAvailable</th>
		<th>FemaleBunkAvailable</th>
		<th>MixedBunkAvailable</th>
		<th>FamilyRoomAvailable</th>
                <th>Phone</th>
                <th>StreetAddress</th>
        </tr>";

        // output data of each row
        while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['FacilityName'] . "</td>";
                echo "<td>" . $row['HoursOfOperation'] . "</td>";
		echo "<td>" . $row['MaleBunkAvailable'] . "</td>";
		echo "<td>" . $row['FemaleBunkAvailable'] . "</td>";
		echo "<td>" . $row['MixedBunkAvailable'] . "</td>";
		echo "<td>" . $row['FamilyRoomAvailable'] . "</td>";
                echo "<td>" . $row['Phone'] . "</td>";
                echo "<td>" . $row['StreetAddress'] . "</td>";
                echo "</tr>";
        }

	echo "</table>";

	$sql = "SELECT ConditionForUse
	FROM ShelterConditionForUse
	WHERE ServiceID=(SELECT ServiceID FROM Shelter WHERE SiteID=$SiteID)";

	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo "<br>";
		echo "Condition For Use: ";
		while ($row = $result->fetch_assoc()) {
			echo $row['ConditionForUse'] . "   ";
		}
	}
	echo "<br><br>";
}

// Food Bank
$sql = "SELECT FacilityName, Phone, StreetAddress
FROM FoodBank
JOIN 
Site on FoodBank.SiteID = Site.SiteID
WHERE Site.SiteID=$SiteID";


$result = $conn->query($sql);

if ($result->num_rows > 0) {
	?><h2><a href="./edit_site_services/edit_food_bank.php">Food Bank</a></h2><?php
        echo "<table width=90% border=1>
        <tr>
                <th>FacilityName</th>
               	<th>Phone</th>
		<th>StreetAddress</th> 
        </tr>";

        // output data of each row
        while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['FacilityName'] . "</td>"; 
		echo "<td>" . $row['Phone'] . "</td>";
		echo "<td>" . $row['StreetAddress'] . "</td>";
		echo "</tr>";
        }
	echo "</table>";
}
$conn->close();
?>

<br><br>
<form action="http://localhost:8888/main-menu"><input type="submit" value="Back" /></form>

</body>
</html>
