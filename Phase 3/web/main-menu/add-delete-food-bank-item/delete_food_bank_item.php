<?php
include $_SERVER['DOCUMENT_ROOT'] . '/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
?>
<!DOCTYPE html>
<html>
<head>
<title> Delete Food Bank Item </title>
</head>
<body>

<h2> Current Food Bank Item </h2>

<?php
$conn = getConn();
$SiteID = $_SESSION['siteid'];
$sql = "SELECT ItemID, ItemName, NumberOfUnits, ExpirationDate, StorageType, Category, Subcategory FROM Item WHERE ServiceID = (SELECT ServiceID FROM FoodBank WHERE SiteID=$SiteID)";
$result = $conn->query($sql); 
if ($result->num_rows > 0) {
        echo "<table width=90% border=1> 
        <tr>
                <th>ItemID</th>
                <th>ItemName</th>
                <th>NumberOfUnits</th>
                <th>ExpirationDate</th>
                <th>StorageType</th>
		<th>Category</th> 
		<th>Subcategory</th>  
        </tr>";
        // output data of each row
        while ($row = $result->fetch_assoc()) { 
                echo "<tr>";
                echo "<td>" . $row['ItemID'] . "</td>";
                echo "<td>" . $row['ItemName'] . "</td>";
                echo "<td>" . $row['NumberOfUnits'] . "</td>";
                echo "<td>" . $row['ExpirationDate'] . "</td>";
                echo "<td>" . $row['StorageType'] . "</td>";
                echo "<td>" . $row['Category'] . "</td>";
		echo "<td>" . $row['Subcategory'] . "</td>";
                echo "</tr>";
        }
}
echo "</table>";
?>

<h2> Delete Food Bank Item</h2>
<form id="myform" action="delete_item_sql.php" method="post">
ItemID<br> <input type="text" name="ItemID"><br><br>
<input type="submit" value="submit" name="submit">
</form>
<br>
<br>
<a href=/main-menu/add-delete-food-bank-item/index.php>Back</a>
<br>
<br>
</body>
</html>
