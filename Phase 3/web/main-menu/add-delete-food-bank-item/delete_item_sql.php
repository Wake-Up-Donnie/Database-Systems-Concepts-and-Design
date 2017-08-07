<?php
include $_SERVER['DOCUMENT_ROOT'] . '/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
$conn = getConn();
if (isset($_POST['submit'])) {
        $ServiceID = 400001;
        $ItemID = $_POST['ItemID']; 
}	

$sql = "DELETE FROM Item WHERE ServiceID=$ServiceID AND ItemID=$ItemID";

if (mysqli_query($conn, $sql)) {
        echo "Item deleted from the database";
}
else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
?>

<br><br>
<form action="http://localhost:8888/main-menu/add-delete-food-bank-item/delete_food_bank_item.php"><input type="submit" value="Delete More Items" /></form>
<br>
<br>
<a href=/main-menu/add-delete-food-bank-item/delete_food_bank_item.php>Back</a>
<br>
<br>