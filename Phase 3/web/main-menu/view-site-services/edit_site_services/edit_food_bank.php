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

<form id="myform" action="edit_food_bank_sql.php" method="post">

<?php
$SiteID = $_SESSION['siteid'];
$conn = getConn();
$sql = "SELECT FacilityName FROM FoodBank WHERE FoodBank.SiteID=$SiteID";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
        echo "<h2>Food Bank</h2>";
        // output data of each row
        while ($row = $result->fetch_assoc()) {
                echo "FacilityName:  " . '<input type="text" name="FacilityName" value="' . $row['FacilityName'] . '"><br>';
        }
}

echo "</table>";
echo "<br><br>";
?>

<input type="submit" value="save change" name="save">
</form>

<form action="delete_food_bank.php" method = "post"><input type="submit" value="delete service" name="delete"></form>

</body>
</html>
