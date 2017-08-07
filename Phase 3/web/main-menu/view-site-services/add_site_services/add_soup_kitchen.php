<?php
include $_SERVER['DOCUMENT_ROOT'] . '/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
?>

<!DOCTYPE html>
<html>
<head>
<title> Add Soup Kitchen </title>
</head?
<body>

<h1> Add Soup Kitchen </h1>

<form id="myform" action="add_soup_kitchen_sql.php" method="post">
FacilityName <input type="text" name="FacilityName"><br><br>
HoursOfOperation <input type="text" name="HoursOfOperation"><br><br>
SeatsCapacity <input type="text" name="SeatsCapacity"><br><br>
SeatsAvailable <input type="text" name="SeatsAvailable"><br><br>
ConditionForUse<br>
<input type="checkbox" name="ConditionForUse[]" value="Drivers License">Drivers License<br>
<input type="checkbox" name="ConditionForUse[]" value="Social Security Card">Social Security Card<br>
<input type="checkbox" name="ConditionForUse[]" value="Birth Certificate">Birth Certificate<br>
<input type="checkbox" name="ConditionForUse[]" value="Proof of Income">Proof of Income<br>
<br>
<input type="submit" value="submit" name="submit">
</form>
</body>
</html>

