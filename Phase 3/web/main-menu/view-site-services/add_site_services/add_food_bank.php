<?php
include $_SERVER['DOCUMENT_ROOT'] . '/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
?>

<!DOCTYPE html>
<html>
<head>
<title> Add Food Bank </title>
</head?
<body>

<h1> Add Food Bank </h1>

<form id="myform" action="add_food_bank_sql.php" method="post">
FacilityName <input type="text" name="FacilityName"><br><br>
<br>
<input type="submit" value="submit" name="submit">
</form>

<br>
<br>
<a href=/main-menu/view-site-services/add_site_services.php>Back</a>
<br>
<br>
</body>
</html>

