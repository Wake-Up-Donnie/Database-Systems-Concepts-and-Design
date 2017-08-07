<?php
include $_SERVER['DOCUMENT_ROOT'] . '/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
?>

<!DOCTYPE html>
<html>
<head>
<title> Edit Soup Kitchen </title>
</head>
<body>

<form id="myform" action="edit_soup_kitchen_sql.php" method="post">

<?php

$SiteID = $_SESSION['siteid'];
$conn = getConn();

$sql = "SELECT FacilityName, HoursOfOperation, SeatsCapacity, SeatsAvailable
FROM SoupKitchen
WHERE SoupKitchen.SiteID=$SiteID";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
        echo "<h2>Soup Kitchen</h2>";

        // output data of each row
        while ($row = $result->fetch_assoc()) {
                echo "FacilityName:  " . '<input type="text" name="FacilityName" value="' . $row['FacilityName'] . '"><br>';
                echo "HoursOfOperation:  " . '<input type="text" name="HoursOfOperation" value="' . $row['HoursOfOperation'] . '"><br>';
                echo "SeatsCapacity:  " . '<input type="text" name="SeatsCapacity" value="' . $row['SeatsCapacity'] . '"><br>';
                echo "SeatsAvailable:  " . '<input type="text" name="SeatsAvailable" value="' . $row['SeatsAvailable'] . '"><br>'; 
        }
}

$sql = "SELECT ConditionForUse
FROM SoupKitchenConditionForUse
WHERE ServiceID=(SELECT ServiceID FROM SoupKitchen WHERE SiteID=$SiteID)";


$DriversLicenseChecked = 0;
$SocialSecurityCardChecked = 0;
$BirthCertificateChecked = 0;
$ProofofIncomeChecked = 0;

$result = $conn->query($sql);
if ($result->num_rows > 0) { 
        while ($row = $result->fetch_assoc()) {
                // echo $row['ConditionForUse'];
                // echo '<input type="text" name="SKConditionForUse1" value="' . $row['ConditionForUse'] . '"><br>';
		if ($row['ConditionForUse'] == "Drivers License") {
			$DriversLicenseChecked = 1;
		}
		else if ($row['ConditionForUse'] == "Social Security Card") {
                        $SocialSecurityCardChecked = 1;
                }
		else if ($row['ConditionForUse'] == "Birth Certificate") {
                        $BirthCertificateChecked = 1;
                }
		else if ($row['ConditionForUse'] == "Proof of Income") {
                        $ProofofIncomeChecked = 1;
                }
        }
}
echo "<br><br>";
?>

ConditionForUse<br>
<?php
if ($DriversLicenseChecked) {
	?><input type="checkbox" name="ConditionForUse[]" value="Drivers License" checked>Drivers License<br><?php
}
else {
	?><input type="checkbox" name="ConditionForUse[]" value="Drivers License">Drivers License<br><?php
}
if ($SocialSecurityCardChecked) {
        ?><input type="checkbox" name="ConditionForUse[]" value="Social Security Card" checked>Social Security Card<br><?php
}
else {
        ?><input type="checkbox" name="ConditionForUse[]" value="Social Security Card">Social Security Card<br><?php
}
if ($BirthCertificateChecked) {
        ?><input type="checkbox" name="ConditionForUse[]" value="Birth Certificate" checked>Birth Certificate<br><?php
}
else {
        ?><input type="checkbox" name="ConditionForUse[]" value="Birth Certificate">Birth Certificate<br><?php
}
if ($ProofofIncomeChecked) {
        ?><input type="checkbox" name="ConditionForUse[]" value="Proof of Income" checked>Proof of Income<br><?php
}
else {
        ?><input type="checkbox" name="ConditionForUse[]" value="Proof of Income">Proof of Income<br><?php
}
?>
<br>

<input type="submit" value="save change" name="save">
</form>

<form action="delete_soup_kitchen.php" method = "post"><input type="submit" value="delete service" name="delete"></form>

</body>
</html>

