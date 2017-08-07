<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
?>

<!DOCTYPE html>
<html>
<head>
<title> Add Food Bank Item </title>
</head>
<body>

<h1> Add Food Bank Item </h1>

<form id="myform" action="add_item_sql.php" method="post">
ItemName<br> <input type="text" name="ItemName"><br><br>
NumberOfUnits<br> <input type="text" name="NumberOfUnits"><br><br>
ExpirationDate<br> <input type="text" name="ExpirationDate"><br><br>
Category/Subcategory<br>
<select name="Subcategory">
	<optgroup label="Food">
		<option name = "Food" value="Vegetables">Vegetables</option>
		<option name = "Food" value="Nuts/grains/beans">Nuts/grains/beans</option>
		<option name = "Food" value="Meat/seafood">Meat/seafood</option>
		<option name = "Food" value="Dairy">Dairy/eggs</option>
		<option name = "Food" value="Sauce/Condiment/Seasoning">Sauce/Condiment/Seasoning</option>
		<option name = "Food" value="Juice/Drink">Juice/Drink</option>	
	</optgroup>
	<optgroup label="Supply">
		<option name = "Supply" value="PersonalHygiene">PersonalHygiene</option>
		<option name = "Supply" value="Clothing">Clothing</option>
		<option name = "Supply" value="Shelter">Shelter</option>
		<option name = "Supply" value="Other">Other</option>		
	</optggroup>
</select><br><br>
StorageType<br>
<input type="radio" name="StorageType" value="Dry Good">Dry Good<br>
<input type="radio" name="StorageType" value="Refrigerated">Refrigerated<br>
<input type="radio" name="StorageType" value="Frozen">Frozen<br>
<br>
<input type="submit" value="submit" name="submit">
</form>

<br>
<br>
<a href=/main-menu/add-delete-food-bank-item/index.php>Back</a>
<br>
<br>
</body>
</html>
