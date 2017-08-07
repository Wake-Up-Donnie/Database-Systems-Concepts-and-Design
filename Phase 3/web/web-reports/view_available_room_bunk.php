<!DOCTYPE html>
<html>
<head>
<title> View Available Room Bunks/Rooms </title>
</head>
<body>

<h1> View Available Room Bunks/Rooms </h1>

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

$sql = "SELECT FacilityName, MaleBunkAvailable, FemaleBunkAvailable, MixedBunkAvailable, FamilyRoomAvailable, Phone, StreetAddress
FROM Shelter 
JOIN Site on Shelter.SiteID=Site.SiteID
WHERE MaleBunkAvailable>0
OR FemaleBunkAvailable>0
OR MixedBunkAvailable>0
OR FamilyRoomAvailable>0";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

	echo "<table width=90% border=1>
	<tr>
		<th>FacilityName</th>
		<th>MaleBunkAvailable</th>
		<th>FemaleBunkAvailable</th>
		<th>MixedBunkAvailable</th>
		<th>FamilyRoomAvailable</th>
		<th>Phone</th>
		<th>Address</th>
	</tr>";

	// output data of each row
	while ($row = $result->fetch_assoc()) {
		echo "<tr>";
		echo "<td>" . $row['FacilityName'] . "</td>";
		echo "<td>" . $row['MaleBunkAvailable'] . "</td>";
		echo "<td>" . $row['FemaleBunkAvailable'] . "</td>";
		echo "<td>" . $row['MixedBunkAvailable'] . "</td>";
		echo "<td>" . $row['FamilyRoomAvailable'] . "</td>";
		echo "<td>" . $row['Phone'] . "</td>";
		echo "<td>" . $row['StreetAddress'] . "</td>";
		echo "</tr>";
	}
}
else {
	echo "Sorry, all shelters are currently at maximum capacity.";
}

echo "</table>";	
$conn->close();
?>

<br><br>
<form action="http://localhost:8888/web-reports"><input type="submit" value="Back" /></form>

</body>
</html>
