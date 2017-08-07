<?php
include $_SERVER['DOCUMENT_ROOT'] . '/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
$conn = getConn();
?>

<!DOCTYPE html>
<html>
<head>
<title> Outstanding Request Report </title>
</head>
<body>

<h1> Outstanding Request Report </h1>

<?php

//Fullfill
if (!empty($_GET['fulfill_request'])) {
    $RequestID = mysqli_real_escape_string($conn, $_GET['fulfill_request']);

    //Update item
    $query = " 
    UPDATE 
    	Item, Request
    SET 
    	ItemProvided = ItemQuantity,
    	NumberOfUnits = NumberOfUnits - ItemQuantity, 
    	Status = 'Closed' 
    WHERE 
	    RequestID = '$RequestID'
	    AND Item.ItemID = Request.ItemID
	    AND NumberOfUnits >= ItemQuantity"; 
    $result = mysqli_query($conn, $query);

    //Update pending request status to close and zero item provided when the item stock quanitiy reached zero
    $query = "
    UPDATE Request, Item 
    SET Status = 'Closed', ItemProvided = 0
    WHERE Request.ItemID = Item.ItemID 
        AND NumberOfUnits = 0
    ";
    $result = $conn->query($query);
   
}

//Deny
if (!empty($_GET['deny_request'])) {
    $RequestID = mysqli_real_escape_string($conn, $_GET['deny_request']);
    $query1 = " UPDATE Request SET ItemProvided = 0, Status = 'Closed' WHERE RequestID = '$RequestID'";
    $result = mysqli_query($conn, $query1);
}

//Partial fulfill
if (isset($_POST['submit'])) {
     foreach($_POST['ItemProvided'] as $index=>$value){
     	
       if($value > 0){
       		//Update request
           $query = " 
           UPDATE 
           	Item, Request 
           SET
           	ItemProvided = $value,
           	NumberOfUnits = NumberOfUnits - $value,
           	Status = 'Closed' 
           WHERE 
           	Item.ItemID = Request.ItemID
           	AND NumberOfUnits >= $value
           	AND RequestID = " .$_POST['RequestID'][$index]. "";
           mysqli_query($conn, $query);

           //Update pending request status to close and zero item provided when the item stock quanitiy reached zero
            $query = "
            UPDATE Request, Item 
            SET Status = 'Closed', ItemProvided = 0
            WHERE Request.ItemID = Item.ItemID 
                AND NumberOfUnits = 0
            ";
            $result = $conn->query($query);
        }        
     }
     echo "<meta http-equiv='refresh' content='0'>";
  }


//Order

$sortDefault = "RequestID";
$sortColumns = array('StorageType', 'Category', 'SubCategory', 'ItemQuantity');

$sort = (isset($_GET['sort']) && in_array($_GET['sort'], $sortColumns)) ? $_GET['sort'] : $sortDefault;
$order = (isset($_GET['order']) && strcasecmp($_GET['order'], 'DESC') == 0) ? 'DESC' : 'ASC'; 

//Create a query
$query = "
SELECT RequestID, ItemName, StorageType, Category, SubCategory, ItemQuantity, ItemProvided, NumberOfUnits
FROM (Request
INNER JOIN Item ON Request.ItemID = Item.ItemID)
WHERE Status = 'Pending' AND Request.ServiceID = (
    Select ServiceID from FoodBank
    INNER JOIN User ON FoodBank.SiteID = User.SiteID
    WHERE username = '$username')
    ORDER BY " . "$sort " . $order;

$result = mysqli_query($conn, $query);

//Check query return if fail
if (!$result) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}

if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
    echo "No outstanding request report available.";
}
?>


<?php
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

if ($row) {

	echo '<form  action="index.php" method="POST">';
	echo '<table width=100% border=1>';
        echo '<tr style="font-weight:bold">';                                              
        echo '<td>RequestID</td>';
        echo '<td>ItemName</td>';
        echo '<td><a href="?sort=StorageType&order=' . ($order == 'DESC' ? 'ASC' : 'DESC') . '">StorageType</td>';
        echo '<td><a href="?sort=Category&order=' . ($order == 'DESC' ? 'ASC' : 'DESC') . '">Category</td>';
        echo '<td><a href="?sort=SubCategory&order=' . ($order == 'DESC' ? 'ASC' : 'DESC') . '">SubCategory</td>';
        echo '<td><a href="?sort=ItemQuantity&order=' . ($order == 'DESC' ? 'ASC' : 'DESC') . '">ItemQuantity</td>';
        echo '<td>ItemProvided</td>';
        echo '<td>Inventroy</td>';
        echo '<td>Fulfill</td>';
        echo '<td>Deny</td>';
        echo '</tr>';
    // output data of each row
    while ($row) {

    	$RequestID = $row['RequestID'];
      $ItemName = $row['ItemName'];
      $StorageType = $row['StorageType'];
      $Category = $row['Category'];
      $SubCategory = $row['SubCategory'];
      $ItemQuantity = $row['ItemQuantity'];
      $NumberOfUnits = $row['NumberOfUnits'];

        echo "<tr>";
   		  echo '<td>' . $RequestID . '<input type="hidden" name="RequestID[]" id="RequestID" value ='. $RequestID .'></td>';        
   		  echo "<td>" . $ItemName . "</td>";
        echo "<td>" . $StorageType . "</td>"; 
        echo "<td>" . $Category . "</td>";
        echo "<td>" . $SubCategory . "</td>";
        echo "<td>" . $ItemQuantity . "</td>";
        echo '<td><input type="number" min="0" max= '. $ItemQuantity .' name="ItemProvided[]" id="ItemProvided" value =""/></td>';
        if ($NumberOfUnits < $ItemQuantity) {
          echo "<td style='background-color:#ff0000'>" . $NumberOfUnits . "</td>";
        } else {
          echo "<td>" . $NumberOfUnits . "</td>";
        } 
        echo '<td><a href="index.php?fulfill_request=' . urlencode($RequestID) . '">Fulfill</a></td>';
        echo '<td><a href="index.php?deny_request=' . urlencode($RequestID) . '">Deny</a></td>';
        echo "</tr>";

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    }

    echo "<tr>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo '<td><input type="submit" name="submit" id ="submit" value ="Submits"/></td>';
    echo "</tr>";
 
}
echo "</table>";
echo "</form>";
		

$conn->close();

echo "<br><br>Note: If number of ItemProvided more than Inventroy, the request will not be fulfilled.";
?>

<br>
<br>
<a href=/main-menu/view-reports/index.php>Back</a>
<br>
<br>

</body>
</html>